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
 * Class Example_TestFramework_TestCase
 *
 * Contains Magento environment bootstrapping for all tests
 */
abstract class Example_TestFramework_TestCase extends PHPUnit_Framework_TestCase
{
	/**
	 * Reset Magento and re-initialise our custom error handler
	 */
	public static function resetMagento()
	{
		Mage::reset();
		Mage::setIsDeveloperMode( true );
		Mage::app( 'admin', 'store', array(
			'config_model' => 'Example_TestFramework_Config'
		) )->setResponse( new Example_TestFramework_Controller_Response_Http() );

		// Fix error handler
		$handler = set_error_handler( function () {
		} );
		set_error_handler( function ( $errno, $errstr, $errfile, $errline ) use ( $handler ) {
			if ( E_WARNING === $errno
			     && 0 === strpos( $errstr, 'include(' )
			     && substr( $errfile, - 19 ) == 'Varien/Autoload.php'
			) {
				return null;
			}
			call_user_func( $handler, $errno, $errstr, $errfile, $errline );
		} );
	}

	/**
	 * Mock session and visitor models
	 */
	public function prepareFrontendDispatch()
	{
		$store = Mage::app()->getDefaultStoreView();
		Mage::app()->setCurrentStore( $store->getCode() );
		$store->setConfig( 'web/url/use_store', 0 );
		$store->setConfig( 'web/url/redirect_to_base', 0 );

		$modules = array( 'core', 'customer', 'checkout', 'catalog', 'reports' );
		foreach ( $modules as $module ) {
			$class = "$module/session";

			$sessionMock = $this->getMockBuilder( Mage::getConfig()->getModelClassName( $class ) )
			                    ->disableOriginalConstructor()
			                    ->getMock();

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

			Mage::unregister( "_singleton/$class" );
			Mage::register( "_singleton/$class", $sessionMock );
			Mage::app()->getConfig()->setModelMock( $class, $sessionMock );
		}

		$cookieMock = $this->getMock( 'Mage_Core_Model_Cookie' );
		$cookieMock->expects( $this->any() )
		           ->method( 'get' )
		           ->will( $this->returnValue( serialize( 'dummy' ) ) );
		Mage::unregister( '_singleton/core/cookie' );
		Mage::register( '_singleton/core/cookie', $cookieMock );

		// Mock visitor log observer
		$logVisitorMock = $this->getMock( 'Mage_Log_Model_Visitor' );
		Mage::app()->getConfig()->setModelMock( 'log/visitor', $logVisitorMock );
	}

	/**
	 * Inject test layout class
	 */
	public function registerTestingLayout()
	{
		$testLayout = new Example_TestFramework_Layout();
		Mage::unregister( "_singleton/core/layout" );
		Mage::register( "_singleton/core/layout", $testLayout );
	}

	public function getBlockStub(
		$originalClassName, $methods = array(), array $arguments = array(),
		$mockClassName = '', $callOriginalConstructor = true,
		$callOriginalClone = true, $callAutoload = true,
		$cloneArguments = false
	)
	{
		$stub = $this->getMock(
			$originalClassName, $methods, $arguments,
			$mockClassName, $callOriginalConstructor,
			$callOriginalClone, $callAutoload,
			$cloneArguments
		);

		return $this->prepareBlockStub($stub);
	}

	public function prepareBlockStub(PHPUnit_Framework_MockObject_MockObject $stub)
	{
		$transport = new stdClass();
		$setNameInLayout = function ($name) use ($transport, $stub) {
			$transport->name = $name;
			return $stub;
		};
		$getNameInLayout = function () use ($transport) {
			return $transport->name;
		};
		$stub->expects($this->any())
		     ->method('setNameInLayout')
		     ->will($this->returnCallback($setNameInLayout));
		$stub->expects($this->any())
		     ->method('getNameInLayout')
		     ->will($this->returnCallback($getNameInLayout));
		return $stub;
	}
}