<?php

use BASE\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
	protected function setUp(): void
	{
		Config::clear();
	}

	public function testLoadXmlMissingHost()
	{
		$this->expectException(RuntimeException::class);
		$this->expectExceptionMessage('Host is not set base.xml: Missing host: local.de');

		Config::setAppDir(__DIR__ . "/dataProvider/ConfigTest/missingHost/");

		Config::loadXml();
	}

	public function testLoadXmlMissingBaseXml()
	{
		$this->expectException(RuntimeException::class);
		$this->expectExceptionMessage('Missing base.xml');

		Config::setAppDir(__DIR__ . "/dataProvider/ConfigTest/");

		Config::loadXml();
	}

	public function testGetHostParameterWithParameter()
	{
		Config::setAppDir(__DIR__ . "/dataProvider/ConfigTest/validConfig/");

		Config::loadXml();

		$localCodeOfHost = Config::getHostParameter('localCode');

		$this->assertEquals('de-de', $localCodeOfHost);
	}

	public function testGetHostParameterWithUnkownParameter()
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectErrorMessage("Missing parameter for host: value");

		Config::setAppDir(__DIR__ . "/dataProvider/ConfigTest/validConfig/");

		Config::loadXml();

		Config::getHostParameter('value');
	}

	public function testGetAppDir()
	{
		$this->assertEquals(Config::getAppDir(), "/opt/project/libs/../");
	}

	public function testGetTemplateEngine()
	{
		Config::setAppDir(__DIR__ . "/dataProvider/ConfigTest/validConfig/");

		Config::loadXml();

		$templateEngine = Config::getTemplateEngine();

		$this->assertTrue(is_array($templateEngine));
		$this->assertArrayHasKey('engine', $templateEngine);
		$this->assertEquals('smarty', $templateEngine['engine']);

		$this->assertArrayHasKey('config', $templateEngine);
		$this->assertTrue(is_object($templateEngine['config']));
	}

	public function testGetTemplateEngineMissingTemplateEngineTag()
	{
		Config::setAppDir(__DIR__ . "/dataProvider/ConfigTest/missingTemplateEngine/");

		Config::loadXml();

		$this->assertNull(Config::getTemplateEngine());
	}


	public function testSetAppDirNotExistingDirectory()
	{
		$appDir = "/aaaaaaaa";

		$this->expectException(RuntimeException::class);
		$this->expectExceptionMessage("Invalid app dir: " . $appDir);

		Config::setAppDir($appDir);
	}

	public function testSetAppDir()
	{
		$appDir = __DIR__;

		Config::setAppDir($appDir);

		$this->assertEquals($appDir, Config::getAppDir());
	}
}
