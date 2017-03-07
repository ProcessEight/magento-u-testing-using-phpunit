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
 * Class Example_TestFramework_Controller_Response_Http
 */
class Example_TestFramework_Controller_Response_Http extends Mage_Core_Controller_Response_Http
{
	/**
	 * @var bool
	 */
	protected $_headersSentFlag = false;

	/**
	 * @param bool $throw
	 *
	 * @return bool
	 */
	public function canSendHeaders( $throw = false )
	{
		if ( $this->_headersSentFlag ) {
			// Will trigger headers sent exception in testing context
			return parent::canSendHeaders($throw);
		}

		return true;
	}

	/**
	 * Note that the native implementation of sendHeaders() contains a lot of business logic, which theoretically
	 * could affect the outcome of tests.
	 * If we want to keep the business logic of the native classes in place, there is no option but to copy
	 * all contents of both the methods Mage_Core_Controller_Response_Http:sendHeaders() and
	 * Zend_Controller_Response_Abstract::sendHeaders() into our own class, and comment out all header() function calls.
	 *
	 * @return $this
	 */
	public function sendHeaders()
	{
		// Use setHeadersSentFlag in >= 1.9.x
//		$this->setHeadersSentFlag(true);
//		 Use canSendHeaders in <= 1.8.x
		$this->canSendHeaders(false);
		return $this;
	}

	/**
	 * @return string $result
	 */
	public function sendResponse()
	{
		ob_start();
		$result = parent::sendResponse();
		ob_end_clean();
		return $result;
	}
}