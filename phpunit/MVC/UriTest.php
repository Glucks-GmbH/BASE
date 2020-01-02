<?php

use BASE\MVC\Uri;
use PHPUnit\Framework\TestCase;

class UriTest extends TestCase
{

	public function testGetLocalCode()
	{
		$_SERVER['REQUEST_URI'] = "/about/";

		$this->assertEquals(Uri::getLocalCode(), '');

		$_SERVER['REQUEST_URI'] = "/de-fr/about/";

		$this->assertEquals(Uri::getLocalCode(), 'de-fr');
	}

	public function testGet()
	{
		$_SERVER['REQUEST_URI'] = "/about/";

		$this->assertEquals(Uri::get(), '/about/');

		$_SERVER['REQUEST_URI'] = "/de-at/about/";

		$this->assertEquals(Uri::get(), '/about/');
	}
}
