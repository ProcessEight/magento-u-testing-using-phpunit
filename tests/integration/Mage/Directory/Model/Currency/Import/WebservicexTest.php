<?php
/**
 * ProjectEight
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact ProjectEight for more information.
 *
 * @category    ProjectEight
 * @package     magento1-testing-using-phpunit.local
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */
/**
 * Testing in Magento 1
 * @link https://gist.github.com/ProjectEight/43f7bc8b0db57b88a85a1d7d74db2a83
 */

class Mage_Directory_Model_Currency_Import_WebservicexTest extends Example_TestFramework_TestCase
{
	public function stubCurrencyModel()
	{
		$mockCurrency = $this->getMock( 'Mage_Directory_Model_Currency' );

		$mockCurrency->expects( $this->any() )
		             ->method( 'getConfigAllowCurrencies' )
		             ->will( $this->returnValue( array( 'USD', 'EUR' ) ) );

		$mockCurrency->expects( $this->any() )
		             ->method( 'getConfigBaseCurrencies' )
		             ->will( $this->returnValue( array( 'USD' ) ) );

		Mage::getConfig()->setModelMock( 'directory/currency', $mockCurrency );
	}

	public function getMockHttpClient( $rate )
	{
		$methods        = array( 'setUri', 'setConfig', 'request', 'getBody' );
		$mockHttpClient = $this->getMock( 'Varien_Http_Client', $methods );
		foreach ( array( 'setUri', 'setConfig', 'request' ) as $method ) {
			$mockHttpClient->expects( $this->atLeastOnce() )
			               ->method( $method )
			               ->withAnyParameters()
			               ->will( $this->returnSelf() );
		}
		$mockHttpClient->expects( $this->atLeastOnce() )
		               ->method( 'getBody' )
		               ->will( $this->returnValue( "<result>$rate</result>" ) );

		return $mockHttpClient;
	}

	public function testFetchRates()
	{
		Mage::app()->setCurrentStore( 'admin' );
		$expectedRate = 0.8;
		$this->stubCurrencyModel();
		$mockHttpClient = $this->getMockHttpClient( $expectedRate );

		$instance = new Mage_Directory_Model_Currency_Import_Webservicex();

		// Use reflection to replace the Varien_Http_Client with a stub
		$property = new ReflectionProperty( $instance, '_httpClient' );
		$property->setAccessible( true );
		$property->setValue( $instance, $mockHttpClient );

		$data = $instance->fetchRates();

		$this->assertArrayHasKey( 'USD', $data );
		$this->assertArrayHasKey( 'EUR', $data['USD'] );
		$this->assertArrayHasKey( 'USD', $data['USD'] );
		$this->assertEquals( $expectedRate, $data['USD']['EUR'] );
		$this->assertEquals( 1, $data['USD']['USD'] );
	}
}
