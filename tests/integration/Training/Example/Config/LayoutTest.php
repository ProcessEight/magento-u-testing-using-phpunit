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
 * Class Training_Example_Config_LayoutTest
 *
 * For testing layout XML
 */
class Training_Example_Config_LayoutTest extends Example_TestFramework_TestCase
{
	protected $classGroup = 'training_example';

	protected function getLayoutConfig( $area )
	{
		$path   = $area . '/layout/updates/' . $this->classGroup . '/file';
		$config = (string) Mage::app()->getConfig()->getNode( $path );

		return $config;
	}

	protected function getLayoutFileName( $area )
	{
		$config = $this->getLayoutConfig( $area );
		$design = Mage::getSingleton( 'core/design_package' );

		return $design->getLayoutFilename( $config );
	}

	protected function getLayoutXml( $area )
	{
		$file = $this->getLayoutFileName( $area );
		$xml  = new Varien_Simplexml_Config();
		$xml->loadFile($file);
		return $xml;
}

	public function testTheModuleHasALayoutFileConfigured()
	{
		$area = 'frontend';
		$file = $this->getLayoutConfig( $area );
		$this->assertTrue( (bool) $file, "No layout XML file configured in $area for {$this->classGroup}" );
	}

	/**
	 * @depends testTheModuleHasALayoutFileConfigured
	 */
	public function testTheLayoutFileExists()
	{
		$file = $this->getLayoutFileName( 'frontend' );
		$this->assertFileExists( $file );
		$this->assertTrue( is_readable( $file ), "Layout XML File is not readable\n$file" );
	}

	/**
	 * @depends testTheLayoutFileExists
	 */
	public function testItHasADefaultUpdtaeHandle()
	{
		$xml  = $this->getLayoutXml( 'frontend' );
		$node = $xml->getNode( 'default' );
		$this->assertTrue( (bool) $node );
	}
}