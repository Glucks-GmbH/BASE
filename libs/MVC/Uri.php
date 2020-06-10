<?php
/**
 * Class to get and parse the REQUEST_URI
 *
 * @package        BASE
 * @subpackage     MVC
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 *
 */

namespace BASE\MVC;

use BASE\Helper\RegExp;

/**
 * Class Uri
 *
 * @package        BASE\MVC
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 */
class Uri
{
	/**
	 * Returns the uri
	 *
	 * @return string
	 */
	private static function getUri(): string
	{
        return filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING);
	}

	/**
	 * Returns the language-country-code cleaned uri
	 *
	 * @return string|null
	 */
	public static function get()
	{
		$uri = self::getUri();
		$code = self::getLocalCode();

		if (!empty($code)) {
			$uri = substr($uri, strlen($code) + 1);
		}

		return $uri;
	}

	/**
	 * Returns the language-country-code if it is used inside the uri
	 *
	 * @return string
	 */
	public static function getLocalCode(): string
	{
		$uri = self::getUri();

		$uriParts = explode("/", $uri);

		if (!isset($uriParts[1]) or !preg_match(RegExp::getLocalCode(), $uriParts[1])) {
			return "";
		} else {
			return $uriParts[1];
		}
	}
}