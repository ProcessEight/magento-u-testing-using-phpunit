<?php

abstract class Training_Example_UnitTestCase extends PHPUnit_Framework_TestCase
{
	/**
	 * Reset Magento and re-initialise our custom error handler
	 */
	public static function resetMagento()
	{
		Mage::reset();

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