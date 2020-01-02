<?php

use BASE\Helper\RegExp;
use PHPUnit\Framework\TestCase;

/**
 * Class RegExpTest
 */
class RegExpTest extends TestCase
{

	/**
	 * @return array
	 */
	public function dataGetLocalCode(): array
	{
		return [
			['de-de', true],
			['de-at', true],
			['fr-ch', true],
			['en-uk', true],
			['en-us', true],
			['', false],
			['de', false],
			['com-en', false]
		];
	}

	/**
	 * @param string $code
	 * @param bool $expected
	 *
	 * @dataProvider dataGetLocalCode
	 */
	public function testGetLocalCode(string $code, bool $expected)
	{
		$this->assertEquals(preg_match(RegExp::getLocalCode(), $code), $expected);
	}

	/**
	 * @return array
	 */
	public function dataGetRexExp(): array
	{
		return [
			['([a-z]{1,})', true],
			['(a)', true],
			['(.*)', true],
			['(a|b)', true],
			['aa', false],
			['hello world(', false],
			['(Hello', false],
			['Hello)', false]
		];
	}

	/**
	 * @param string $code
	 * @param bool $expected
	 *
	 * @dataProvider dataGetRexExp
	 */
	public function testRegExp(string $code, bool $expected)
	{
		$this->assertEquals(preg_match(RegExp::getRexExp(), $code), $expected);
	}
}
