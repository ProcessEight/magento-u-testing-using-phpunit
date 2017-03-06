<?php

// No need to initialise the Magento environment beyond the autoloader for unit tests
require_once __DIR__ . '/../../www/app/Mage.php';

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
	if(E_WARNING === $errno
	   && 0 === strpos($errstr, 'include(')
	   && substr($errfile, -19) == 'Varien/Autoload.php') {
		return null;
	}
	// Delegate to the standard PHP error handler by returning false
	return false;
});
