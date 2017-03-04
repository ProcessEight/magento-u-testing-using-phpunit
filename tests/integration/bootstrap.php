<?php

require_once __DIR__ . '/../../www/app/Mage.php';

//require_once __DIR__ . '/Training/Example/IntegrationTestCase.php';
//Training_Example_IntegrationTestCase::resetMagento();
Mage::setIsDeveloperMode(true);
Mage::app();
$handler = set_error_handler(function () {});
set_error_handler(function ($errno, $errstr, $errfile, $errline) use ($handler) {
	if(E_WARNING === $errno
	   && 0 === strpos($errstr, 'include(')
	   && substr($errfile, -19) == 'Varien/Autoload.php') {
		return null;
	}
	return call_user_func($handler, $errno, $errstr, $errfile, $errline);
});