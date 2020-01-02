<?php
/**
 * Helper class with regular expression
 *
 * @package    BASE
 * @subpackage Helper
 * @author     Frederik Glücks <frederik@gluecks-gmbh.de>
 *
 */

namespace BASE\Helper;

/**
 * Helper class with regular expression
 *
 * @author     Frederik Glücks <frederik@gluecks-gmbh.de>
 * @package    BASE
 * @subpackage Helper
 * @version    v0.1
 */
abstract class RegExp
{
	/**
	 * Returns a regular expression to detect language (ISO-639-1-Codes) and (ISO 3166-1 alpha-2) country codes. Like "en-uk" for English United Kingdom
	 *
	 * @return string
	 */
	public static function getLocalCode(): string
	{
		return "/^[a-z]{2}-[a-z]{2}$/";
	}

	/**
	 * Return a regular expression to detect a regular expression.
	 *
	 * @return string
	 */
	public static function getRexExp(): string
	{
		return "/(\(.*\))/";
	}
}