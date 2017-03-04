<?php

abstract class Training_Example_IntegrationTestCase extends PHPUnit_Framework_TestCase
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
		) );

		// Fix error handler
		$handler = set_error_handler( function () {} );
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
}