<?php

use BASE\MVC\Routes;
use BASE\MVC\Links;
use BASE\Config;
use PHPUnit\Framework\TestCase;

class LinksTest extends TestCase
{
	public function testGetUriNoRoutes()
	{
		$this->expectException(RuntimeException::class);
		$this->expectExceptionMessage('Empty routes list');

		Links::getUri("/Website::homepage");
	}

	public function testSetRoutes()
	{
		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/validRoutes/");

		$Routes = new Routes('de-de');
		$this->assertTrue(Links::setRoutes($Routes->getRoutes()));
	}

	public function testGetUri()
	{
		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/validRoutes/");

		$Routes = new Routes('de-de');
		$this->assertTrue(Links::setRoutes($Routes->getRoutes()));

		$this->assertEquals("/", Links::getUri("/Website::homepage"));

		$this->assertEquals("/about/", Links::getUri("/About::overview"));
		$this->assertEquals("/about/history/", Links::getUri("/About::history"));
		$this->assertEquals("/about/history/timeline/", Links::getUri("/About::historyTimeline"));

		$this->assertEquals("/stores/", Links::getUri("/Stores::overview"));
		$this->assertEquals("/stores/london/", Links::getUri("/Stores::details", ['london']));
		$this->assertEquals("/stores/berlin/", Links::getUri("/Stores::details", ['berlin']));
	}

	public function testGetUriRegExpEmptyValues()
	{
		$this->expectException(RuntimeException::class);
		$this->expectErrorMessage("Empty value for regular expression uri. Controller: /Stores::details");

		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/validRoutes/");

		$Routes = new Routes('de-de');
		$this->assertTrue(Links::setRoutes($Routes->getRoutes()));

		$this->assertEquals("/stores/berlin/", Links::getUri("/Stores::details", []));
	}

	public function testGetUriRegExpInvalidValue()
	{
		$this->expectException(RuntimeException::class);
		$this->expectErrorMessage("Value does not match to regular expression. Controller: /Stores::details RegExp: ([a-z]{1,}) Value: Hamburg1");

		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/validRoutes/");

		$Routes = new Routes('de-de');
		$this->assertTrue(Links::setRoutes($Routes->getRoutes()));

		$this->assertEquals("/stores/berlin/", Links::getUri("/Stores::details", ['Hamburg1']));
	}

	public function testGetUriUnkownController()
	{
		$this->expectWarning();
		$this->expectWarningMessage('Controller not found: \Stores::overview');

		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/validRoutes/");

		$Routes = new Routes('de-de');
		$this->assertTrue(Links::setRoutes($Routes->getRoutes()));
		Links::getUri("\Stores::overview");
	}
}
