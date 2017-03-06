<?php

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