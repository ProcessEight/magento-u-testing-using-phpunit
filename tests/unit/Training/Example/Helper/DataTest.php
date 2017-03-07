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

/**
 * Class Training_Example_DataTest
 */
class Training_Example_DataTest extends PHPUnit_Framework_TestCase
{
	protected $_class = 'Training_Example_Helper_Data';

	protected $_method = 'getRedirectTargetUrl';

	/**
	 * @test
	 */
	public function testExampleHelperExists()
	{
		$this->assertTrue(
			class_exists( $this->_class ),
			"Class {$this->_class} doesn't exist"
		);
	}

	/**
	 * @test
	 * @depends testExampleHelperExists
	 */
	public function testGetRedirectTargetUrlExists()
	{
		$this->assertTrue(
			is_callable( array( $this->_class, $this->_method ) ),
			"{$this->_class}::{$this->_method} is not callable."
		);
	}

	public function testGetRedirectTargetUrlReturnsValue()
	{
		$configPath = 'training/example/redirect_target';
		$baseUrl    = 'http://magento.dev/';
		$urlPath    = 'training/example/redirect';
		$expected   = $baseUrl . $urlPath . '/';

		/*
		 * Store model mock
		 *
		 * Basically, this is saying
		 * "Mage_Core_Model_Store::getConfig() should be called exactly once with $configPath as an argument and it should return $urlPath"
		 */
		$store = $this->getMock( 'Mage_Core_Model_Store' );
		$store->expects( $this->once() )
		      ->method( 'getConfig' )
		      ->with( $configPath )
		      ->will( $this->returnValue( $urlPath ) );

		/*
		 * URL model mock
		 *
		 * Basically, this is saying
		 * "Mage_Core_Model_Url::getUrl" should be called exactly once with $urlPath as an argument and it should return $expected"
		 */
		$urlModel = $this->getMock( 'Mage_Core_Model_Url' );
		$urlModel->expects( $this->once() )
		         ->method( 'getUrl' )
		         ->with( $urlPath )
		         ->will( $this->returnValue( $expected ) );

		$helper = new$this->_class( $store, $urlModel );
		$value  = call_user_func( array( $helper, $this->_method ) );
		$this->assertSame( $expected, $value );
	}

}