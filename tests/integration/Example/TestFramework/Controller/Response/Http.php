<?php

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