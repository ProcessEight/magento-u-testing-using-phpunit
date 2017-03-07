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
 * Class Training_Example_Dispatch_HomeTest
 *
 * Testing the homepage
 */
class Training_Example_Dispatch_HomeTest extends Example_TestFramework_TestCase
{
	public function setUp()
	{
		self::resetMagento();
		$this->prepareFrontendDispatch();
		$this->registerTestingLayout();
		$mockPoll = $this->getBlockStub('Mage_Poll_Block_ActivePoll');
		Mage::app()->getLayout()->setBlockStub('poll/activePoll', $mockPoll);
	}

	public function testControllerActionCmsHomepage()
	{
		// Config fixtures
		Mage::app()->getStore()
		    ->setConfig( 'web/default/front', 'cms' )
		    ->setConfig( 'web/default/cms_home_page', 'home' ); // Current request

		// Test the homepage by setting the URL path we're testing directly on the request object
		Mage::app()->getRequest()->setPathInfo( '/' );

		Mage::app()->getFrontController()->dispatch();

		$response = Mage::app()->getResponse();

		$this->assertEquals( 200, $response->getHttpResponseCode(),
			"HTTP code not 200" );

		$found = strpos($response->getBody(), 'Products' );
		$this->assertTrue( false !== $found, 'String not found in response body' );
	}
}