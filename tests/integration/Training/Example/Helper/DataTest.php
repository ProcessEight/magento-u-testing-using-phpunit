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
 *
 * Testing the Helper Data class
 */
class Training_Example_DataTest extends PHPUnit_Framework_TestCase
{
	protected $_class = 'Training_Example_Helper_Data';

	/**
	 * Pre-populate the Magento registry with common session objects
	 */
	public function setUp()
	{
		$modules = array( 'core', 'customer', 'checkout', 'catalog', 'reports' );
		foreach ( $modules as $module ) {
			$class       = "$module/session";
			$phpClass    = Mage::getConfig()->getModelClassName( $class );
			$sessionMock = $this->getMockBuilder( $phpClass )
			                    ->disableOriginalConstructor()
			                    ->getMock();

			// Stub out key methods
			$sessionMock->expects( $this->any() )
			            ->method( 'start' )
			            ->will( $this->returnSelf() );
			$sessionMock->expects( $this->any() )
			            ->method( 'init' )
			            ->will( $this->returnSelf() );
			$sessionMock->expects( $this->any() )
			            ->method( 'getMessages' )
			            ->will( $this->returnValue(
				            Mage::getModel( 'core/message_collection' )
			            ) );
			$sessionMock->expects( $this->any() )
			            ->method( 'getSessionIdQueryParam' )
			            ->will( $this->returnValue(
				            Mage_Core_Model_Session_Abstract::SESSION_ID_QUERY_PARAM
			            ) );
			$sessionMock->expects( $this->any() )
			            ->method( 'getCookieShouldBeReceived' )
			            ->will( $this->returnValue( false ) );

			// Inject our mocked session into the registry
			Mage::unregister( "_singleton/$class" );
			Mage::register( "_singleton/$class", $sessionMock );
		}
	}

	/**
	 * @test
	 */
	public function exampleHelperExists()
	{
		$this->assertTrue(
			class_exists( $this->_class ),
			"Class {$this->_class} doesn't exist"
		);
	}

	/**
	 * @test
	 * @depends exampleHelperExists
	 */
	public function getRedirectTargetUrlReturnsValue()
	{
		$store    = Mage::app()->getStore();
		$store
		    ->setConfig( 'web/unsecure/base_url', 'http://magento1-testing-using-phpunit.local/' )
			->setConfig('training/example/redirect_target', 'training/example/redirect' );


		$urlModel = Mage::getModel( 'core/url' )->setUseSession( false );
		$helper   = new $this->_class( $store, $urlModel );

		$method = 'getRedirectTargetUrl';

		$this->assertTrue(
			is_callable( array( $this->_class, $method ) ),
			"{$this->_class}::{$method} is not callable."
		);

		$value = call_user_func( array( $helper, $method ) );
		// Fix PhpStorm bug where it appends its own PHPUnit bootstrapping script to the end of the base URL
		$value = str_replace('ide-phpunit.php/', '', $value);
		$expected = 'http://magento1810.local/training/example/redirect/';

		$this->assertSame( $expected, $value );
	}
}