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
 * Class Training_Example_Config_SystemTest
 *
 * For testing system.xml
 */
class Training_Example_Config_SystemTest extends Example_TestFramework_TestCase
{
	protected function getFile()
	{
		$dir = Mage::getModuleDir( 'etc', 'Training_Example' );

		return "$dir/system.xml";
	}

	protected function getXml()
	{
		$file = $this->getFile();
		$xml  = simplexml_load_file( $file );

		return $xml;
	}

	public function assertFieldDefined( $path, $message = '' )
	{
		@list( $section, $group, $field ) = explode( '/', $path );
		$nodePath = "sections/$section/groups/$group/fields/$field";
		$result   = $this->getXml()->xpath( $nodePath );
		if ( ! $message ) {
			$defaultMessage = sprintf(
				"System configuration field '%s' not defined", $path
			);
		}
		if ( ! $result ) {
			$this->fail( $message ?: $defaultMessage );
		}
	}

	/**
	 * @test
	 */
	public function itShouldHaveAnApiKeyField()
	{
		$this->assertFieldDefined( 'training_example/general/api_key' );
	}
}
