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
 * Class Training_Example_Helper_Data
 */
class Training_Example_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $_store;
	protected $_urlModel;

	/**
	 * Training_Example_Helper_Data constructor.
	 *
	 * Note that we don't enforce the passing of the store or url models, this is because these are not always needed
	 * if the helper is used for translation, for example
	 *
	 * @param Mage_Core_Model_Store|null $store
	 * @param Mage_Core_Model_Url|null   $url
	 */
	public function __construct( Mage_Core_Model_Store $store = null, Mage_Core_Model_Url $url = null
	)
	{
		$this->_store = $store;
		$this->_urlModel = $url;
	}

	public function getRedirectTargetUrl()
	{
		$value = $this->getStore()->getConfig( 'training/example/redirect_target' );

		return $this->getUrlModel()->getUrl( $value );
	}

	/**
	 * @return Mage_Core_Model_Store
	 */
	public function getStore()
	{
		if (is_null($this->_store)) {
			$this->_store = Mage::app()->getStore();
		}
		return $this->_store;
	}

	/**
	 * @return Mage_Core_Model_Url
	 */
	public function getUrlModel()
	{
		if (is_null($this->_urlModel)) {
			$this->_urlModel = Mage::getModel('core/url');
		}
		return $this->_urlModel;
	}
}