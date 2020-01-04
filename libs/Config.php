<?php
/**
 * Config
 *
 * @package        BASE
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 *
 */

namespace BASE;

use \InvalidArgumentException;
use \RuntimeException;

/**
 * Class Config
 *
 * @package        BASE
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 * @version        v0.1
 */
class Config
{

	/**
	 * String with the full path of the app directory.
	 *
	 * @var string
	 */
	private static $appDir = "";

	/**
	 * XML-Object with the host part of the current HTTP_HOST from the config.xml
	 *
	 * @var object
	 */
	private static $currentHost;

	/**
	 *
	 * Compkete XML-Object from the config.xml
	 *
	 * @var object
	 */
	private static $config;


	/**
	 * Clears all private variables
	 *
	 * @return void
	 */
	public static function clear()
	{
		self::$config = null;
		self::$appDir = "";
		self::$currentHost = "";
	}


	/**
	 * Parse the BASE config from <app-dir>/config/base.xml
	 * Extracts current host part from the config object and link to the privat var $currentHost. Which is usable by getHostParameter()
	 *
	 */
	public static function loadXml()
	{
		$configFile = self::getAppDir() . "config/base.xml";

		if (!file_exists($configFile)) {
			throw new RuntimeException("Missing base.xml", E_ERROR);
		} else {
			$httpHost = filter_input(INPUT_SERVER, "HTTP_HOST", FILTER_SANITIZE_STRING);

			self::$config = simplexml_load_file($configFile);
			self::$currentHost = null;

			foreach (self::$config->virtual_hosts->host as $host) {
				if ($host->domain == $httpHost) {
					self::$currentHost = $host;
					break;
				}
			}

			if (is_null(self::$currentHost)) {
				throw new RuntimeException("Host is not set base.xml: Missing host: " . $httpHost, E_ERROR);
			}
		}
	}

	/**
	 * Returns the full config object of the current host. Can be limited by using a element name of the first level as function parameter.
	 *
	 * @param string $parameter
	 *
	 */
	public static function getHostParameter(string $parameter = "")
	{
		if (!empty($parameter)) {
			if (!isset(self::$currentHost->$parameter)) {
				throw new InvalidArgumentException("Missing parameter for host: " . $parameter, E_ERROR);
			} else {
				return self::$currentHost->$parameter;
			}
		} else {
			return self::$currentHost;
		}
	}

	/**
	 * Can be used to set an custom app directory.
	 *
	 * @param string $appDir
	 */
	public static function setAppDir(string $appDir)
	{
		if (is_string($appDir) and file_exists($appDir)) {
			self::$appDir = $appDir;
		} else {
			throw new RuntimeException("Invalid app dir: " . $appDir, E_ERROR);
		}
	}

	/**
	 * Return the full directory path to the app directory.
	 *
	 * @return string
	 */
	public static function getAppDir()
	{
		if (!empty(self::$appDir)) {
			return self::$appDir;
		} else {
			return (strpos(__DIR__, "vendor")) ? __DIR__ . "/../../../../" : __DIR__ . "/../";
		}
	}

	/**
	 * Returns the template engines for the views and there config elements
	 *
	 * @return array|null
	 */

	public static function getTemplateEngine()
	{
		if (!isset(self::$config->templates)) {
			return null;
		} else {
			$templateEngine = [
				'engine' => (string)self::$config->templates->attributes()->engine,
				'config' => self::$config->templates
			];

			return $templateEngine;
		}
	}
}
