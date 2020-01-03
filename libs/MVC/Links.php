<?php
/**
 * Class to get the local information from uri or config.
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
 * Class to uris from controller. Used as Link-Builder
 *
 * @package        BASE\MVC
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 */
class Links
{

	/**
	 * Array to store the controller and uri data.
	 *
	 * @var array
	 */
	private static $links = [];

	/**
	 * Stores the routes and builds an array for the getUri function
	 *
	 * @param array $routes
	 *
	 * @return bool
	 */
	public static function setRoutes(array $routes)
	{
		if (!is_array($routes) or count($routes) < 1) {
			throw new \InvalidArgumentException("Invalid or empty routes array", E_ERROR);
		} else {
			self::$links = [];

			foreach ($routes as $uri => $controllerData) {
				$controllerData['uri'] = $uri;
				self::$links[$controllerData['controller']] = $controllerData;
			}

			return true;
		}
	}

	/**
	 * Build the uri to a given controller. Fills the regular expression parts with the given values.
	 *
	 * @param string $requestedController
	 * @param array  $regExpValues
	 *
	 * @return string|null
	 */
	public static function getUri(string $requestedController, array $regExpValues = [])
	{
		if (count(self::$links) < 1) {
			throw new \RuntimeException("Empty routes list", E_ERROR);
		} else {
			foreach (self::$links as $controller => $controllerData) {
				if ($controller == $requestedController) {
					$uri = $controllerData['uri'];

					if ($controllerData['regExp'] === true) {
						$uriRegExpParts = preg_split(RegExp::getRexExp(), $controllerData['uri'], -1, PREG_SPLIT_DELIM_CAPTURE);

						foreach ($uriRegExpParts as $key => $part) {
							if (substr($part, 0, 1) == "(") {
								$value = array_shift($regExpValues);

								if (empty($value)) {
									throw new \RuntimeException("Empty value for regular expression uri. Controller: " . $controller, E_ERROR);
								}
								if (!preg_match("/^" . $part . "$/", $value)) {
									throw new \RuntimeException("Value does not match to regular expression. Controller: " . $controller . " RegExp: " . $part . " Value: " . $value, E_ERROR);
								} else {
									$uriRegExpParts[$key] = $value;
								}
							}
						}

						$uri = join($uriRegExpParts);
					}

					return $uri;
				}
			}

			trigger_error("Controller not found: " . $requestedController, E_USER_WARNING);

			return null;
		}
	}
}