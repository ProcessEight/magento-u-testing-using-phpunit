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
 * Class Training_Example_Config_ConfigTest
 *
 * For testing config.xml
 */
class Training_Example_Config_ConfigTest extends Example_TestFramework_TestCase
{
	protected $module = 'Training_Example';

	public function testTheModuleIsKnown()
	{
		$config = Mage::getConfig()->getNode( "modules/{$this->module}" );
		$this->assertTrue(false !== $config, sprintf( 'Module "%s" not known to Magento', $this->module ) );
	}

	public function testTheModuleIsActive()
	{
		$config = Mage::getConfig()->getNode( "modules/{$this->module}" );
		$this->assertEquals('true', (string) $config->active, sprintf( 'Module "%s" not active', $this->module ) );
	}

	public function testConfigXmlFileExists() {
		$dir = Mage::getModuleDir('etc', $this->module);
		$file = "$dir/config.xml";
		$this->assertFileExists($file);
	}

	public function testItHasAHelperClassGroup()
	{
		$classGroup = strtolower( $this->module );
		$class      = Mage::getConfig()->getHelperClassName( $classGroup );
		$this->assertEquals( "{$this->module}_Helper_Data", $class );
	}

	public function testItHasAModelClassGroup()
	{
		$classGroup = strtolower( $this->module );
		$class      = Mage::getConfig()->getGroupedClassName( 'model', "$classGroup/test" );
		$this->assertEquals( "{$this->module}_Model_Test", $class );
	}

	public function testItHasABlockClassGroup()
	{
		$classGroup = strtolower( $this->module );
		$class      = Mage::getConfig()->getGroupedClassName( 'block', "$classGroup/test" );
		$this->assertEquals( "{$this->module}_Block_Test", $class );
	}
}