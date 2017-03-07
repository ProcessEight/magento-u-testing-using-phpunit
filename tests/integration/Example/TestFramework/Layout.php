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
 * Class Example_TestFramework_Layout
 *
 * Framework class to enable testing of layout blocks
 */
class Example_TestFramework_Layout extends Mage_Core_Model_Layout
{
	protected $_stubs = array();

	protected function _getBlockInstance( $block, array $attributes = array() )
	{
		$block = (string) $block;
		if ( isset( $this->_stubs[ $block ] ) ) {
			return $this->_stubs[ $block ];
		}

		return parent::_getBlockInstance( $block, $attributes );
	}

	public function getBlockSingleton( $type )
	{
		$type = (string) $type;
		if ( isset( $this->_stubs[ $type ] ) ) {
			return $this->_stubs[ $type ];
		}

		return parent::getBlockSingleton( $type );
	}

	public function setBlockStub( $blockClass, $stub )
	{
		$this->_stubs[ $blockClass ] = $stub;

		return $this;
	}
}