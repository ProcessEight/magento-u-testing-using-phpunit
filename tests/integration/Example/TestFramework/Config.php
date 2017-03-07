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
 * Class Example_TestFramework_Config
 *
 * Framework class to allow testing of statically-instantiated models
 */
class Example_TestFramework_Config extends Mage_Core_Model_Config
{
	protected $_mocks = array(
		'model' => array()
	);

	public function setModelMock($modelClass, $mock)
	{
		$modelClass = (string)$modelClass;
		$this->_mocks['model'][$modelClass] = $mock;
	}

	public function getModelInstance( $modelClass = '', $constructArguments = array() )
	{
		$modelClass = (string)$modelClass;

		if(isset($this->_mocks['model'][$modelClass])) {
			return $this->_mocks['model'][$modelClass];
		}

		return parent::getModelInstance( $modelClass, $constructArguments );
	}
}