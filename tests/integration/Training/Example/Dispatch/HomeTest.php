<?php

class Training_Example_Dispatch_HomeTest extends Example_TestFramework_TestCase
{
	public function setUp()
	{
		Example_TestFramework_TestCase::resetMagento();
		$this->prepareFrontendDispatch();
	}

	public function testControllerActionCmsHomepage()
	{
		// Config fixtures
		Mage::app()->getStore()
		    ->setConfig( 'web/default/front', 'cms' )
		    ->setConfig( 'web/default/cms_home_page', 'home' ); // Current request

		Mage::app()->getRequest()->setPathInfo( '/' );

		Mage::app()->getFrontController()->dispatch();

		$response = Mage::app()->getResponse();

		$this->assertEquals( 200, $response->getHttpResponseCode(),
			"HTTP code not 200" );

		$found = strpos($response->getBody(), 'New Products' );
		$this->assertTrue( false !== $found, 'String not found in response body' );
	}
}