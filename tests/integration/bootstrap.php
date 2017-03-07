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


//require_once __DIR__ . '/../../www/app/Mage.php';
require_once __DIR__ . '/../../../magento1810.local/www/app/Mage.php';

require_once __DIR__ . '/Example/TestFramework/TestCase.php';
require_once __DIR__ . '/Example/TestFramework/Config.php';
require_once __DIR__ . '/Example/TestFramework/Layout.php';
require_once __DIR__ . '/Example/TestFramework/Controller/Response/Http.php';

error_reporting((E_ALL | E_STRICT) ^ E_DEPRECATED);

Mage::setIsDeveloperMode(true);
Mage::app('admin', 'store', array(
	'config_model' => 'Example_TestFramework_Config'
))->setResponse(new Example_TestFramework_Controller_Response_Http());

Example_TestFramework_TestCase::resetMagento();
