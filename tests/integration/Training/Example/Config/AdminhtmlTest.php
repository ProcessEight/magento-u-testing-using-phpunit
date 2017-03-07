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
 * Test Class for testing Adminhtml.xml
 *
 * Class Training_Example_Config_AdminhtmlTest
 */
class Training_Example_Config_AdminhtmlTest extends Example_TestFramework_TestCase
{
	protected function getFile()
	{
		$dir = Mage::getModuleDir( 'etc', 'Training_Example' );

		return "$dir/adminhtml.xml";
	}

	protected function getXml()
	{
		$file = $this->getFile();
		$xml  = simplexml_load_file( $file );

		return $xml;

	}

	/**
	 * @test
	 */
	public function itShouldHaveAnAdminhtmlXml()
	{
		$this->assertFileExists( $this->getFile() );
	}

	public function assertMenuDefined( $path, $action = '', $message = '' )
	{
		$nodePath = 'menu/' . implode( '/children/', explode( '/', $path ) );
		$result   = $this->getXml()->xpath( $nodePath );
		if ( ! $message ) {
			$defaultMessage = sprintf(
				'Failed to assert the menu %s is defined', $path
			);
		}
		if ( ! $result ) {
			$this->fail( $message ?: $defaultMessage );
		}
		if ( $action && $action != (string) $result[0]->action ) {
			if ( ! $message ) {
				$defaultMessage = sprintf(
					'Failed to assert the %s menu action %s is defined', $path, $action );
			}
			$this->fail( $message ?: $defaultMessage );
		}
	}

	public function assertAclDefined( $path, $message = null )
	{
		$nodePath = 'acl/resources/admin/children/' . implode( '/children/', explode( '/', $path ) );
		$result   = $this->getXml()->xpath( $nodePath );
		if ( ! $message ) {
			$message = sprintf(
				'Failed to assert the ACL %s is defined', $path
			);
		}
		if ( ! $result ) {
			$this->fail( $message );
		}
	}

	/**
	 * @test
	 */
	public function itShouldAddAMenuEntry()
	{
		$this->assertMenuDefined(
			'catalog/training_example', 'adminhtml/training_example'
		);
	}

	/**
	 * @test
	 */
	public function itShouldAddAMenuAclEntry()
	{
		$this->assertAclDefined( 'catalog/training_example' );
	}

	/**
	 * @test
	 */
	public function itShouldAddASystemConfigAclEntry()
	{
		$this->markTestSkipped('Test should be implemented if custom sections are added to admin.');
		$this->assertAclDefined( 'system/config/trainingexample' );
	}
}