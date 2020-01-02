<?php

use BASE\Config;
use BASE\MVC\Routes;
use PHPUnit\Framework\TestCase;

class RoutesTest extends TestCase
{

	public function testMissingRouteXML()
	{
		$this->expectException(RuntimeException::class);
		$this->expectDeprecationMessage("Duplicate uri: / in language-country: de-de");

		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/duplicateUri/");

		new Routes('de-de');
	}

	public function testExistingUri()
	{
		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/validRoutes/");

		$Routes = new Routes('de-de');
		$this->assertEquals('/Website::homepage', $Routes->getControllerByUri('/')['controller']);

		$this->assertEquals('/About::overview', $Routes->getControllerByUri('/about/')['controller']);
		$this->assertEquals('/About::history', $Routes->getControllerByUri('/about/history/')['controller']);
		$this->assertEquals('/About::historyTimeline', $Routes->getControllerByUri('/about/history/timeline/')['controller']);

		$this->assertEquals('/Stores::overview', $Routes->getControllerByUri('/stores/')['controller']);
		$this->assertEquals('/Stores::details', $Routes->getControllerByUri('/stores/london/')['controller']);
		$this->assertEquals('london', $Routes->getControllerByUri('/stores/london/')['regExpMatches'][1]);
	}

	public function testNotExistingUri()
	{
		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/validRoutes/");

		$Routes = new Routes('de-de');
		$this->assertNull($Routes->getControllerByUri('/aaaa'));
		$this->assertNull($Routes->getControllerByUri('/stores/london111/'));
	}

	public function testNotExistingUriInCountry()
	{
		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/validRoutes/");

		$Routes = new Routes('de-at');
		$this->assertNull($Routes->getControllerByUri('/'));
	}

	public function testNoRoutes()
	{
		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/noRoutes/");

		$Routes = new Routes('de-de');
		$this->assertNull($Routes->getControllerByUri('/'));
	}

	public function testNoUriInRoute()
	{
		$this->expectException(RuntimeException::class);
		$this->expectDeprecationMessage("Missing uri for /Website::homepage in language-country: de-de");

		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/noUriInRoute/");

		new Routes('de-de');
	}

	public function testDuplicateUri()
	{
		$this->expectException(RuntimeException::class);
		$this->expectDeprecationMessage("Duplicate uri: / in language-country: de-de");

		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/duplicateUri/");

		new Routes('de-de');
	}

	public function testMissingSlashes()
	{
		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/missingSlashes/");

		$Routes = new Routes('de-de');

		$this->assertEquals('/About::overview', $Routes->getControllerByUri('/about/')['controller']);
		$this->assertEquals('/About::history', $Routes->getControllerByUri('/about/history/')['controller']);
		$this->assertEquals('/About::team', $Routes->getControllerByUri('/about/team/')['controller']);

		$this->assertEquals('/Stores::overview', $Routes->getControllerByUri('/stores/')['controller']);

		$this->assertEquals('/Stores::london', $Routes->getControllerByUri('/stores/london/')['controller']);
		$this->assertEquals('/Stores::berlin', $Routes->getControllerByUri('/stores/berlin/')['controller']);
		$this->assertEquals('/Stores::wien', $Routes->getControllerByUri('/stores/wien/')['controller']);
	}

	public function testEmptyCodeAttribute()
	{
		$this->expectException(RuntimeException::class);
		$this->expectDeprecationMessage("Invalid code attribute");

		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/emptyCodeAttribute/");

		new Routes('de-de');
	}

	public function testInvalidCodeAttribute()
	{
		$this->expectException(RuntimeException::class);
		$this->expectDeprecationMessage("Invalid code attribute");

		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/invalidCodeAttribute/");

		new Routes('de-de');
	}

	public function testEmptyControllerAttribute()
	{
		$this->expectException(RuntimeException::class);
		$this->expectDeprecationMessage("Empty controller attribute");

		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/emptyControllerAttribute/");

		new Routes('de-de');
	}

	public function testEmptyValueAttribute()
	{
		$this->expectException(RuntimeException::class);
		$this->expectDeprecationMessage("Empty value attribute");

		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/emptyValueAttribute/");

		new Routes('de-de');
	}

	public function testGetRoutes()
	{
		Config::setAppDir(__DIR__ . "/dataProvider/RoutesTest/validRoutes/");

		$Routes = new Routes('de-de');

		$routesList = $Routes->getRoutes();

		$this->assertTrue(is_array($routesList));
		$this->assertEquals(6, count($routesList));
	}
}
