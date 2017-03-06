<?php

require_once __DIR__ . '/../../www/app/Mage.php';

require_once __DIR__ . '/Example/TestFramework/TestCase.php';
require_once __DIR__ . '/Example/TestFramework/Config.php';
require_once __DIR__ . '/Example/TestFramework/Controller/Response/Http.php';

Mage::setIsDeveloperMode(true);
Mage::app('admin', 'store', array(
	'config_model' => 'Example_TestFramework_Config'
))->setResponse(new Example_TestFramework_Controller_Response_Http());

Example_TestFramework_TestCase::resetMagento();
