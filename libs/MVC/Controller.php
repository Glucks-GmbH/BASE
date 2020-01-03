<?php
/**
 * Header
 *
 * @package        BASE
 * @subpackage     MVC
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 *
 */

namespace BASE\MVC;

use BASE\Config;

/**
 * Class Controller
 *
 * @package        BASE
 * @subpackage     MVC
 * @version        v0.1
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 *
 */
class Controller
{
	/**
	 * Open a controller class and added regular expression matches to the controller function if the uri uses a regular expression.
	 *
	 * @param string $controller
	 *
	 * @param array  $regExpMatches
	 *
	 * @param string $localCode
	 *
	 * @return bool
	 */
	public function load(string $controller, array $regExpMatches, string $localCode): bool
	{
		$appDir = Config::getAppDir();

		$class = substr($controller, 0, strpos($controller, "::"));
		$fct = substr($controller, strpos($controller, "::") + 2);

		if (substr($class, 0, 1) == '/') {
			$class = substr($class, 1);
		}

		$controllerFile = $appDir . "public/controller/" . $class . ".php";

		if (file_exists($controllerFile)) {
			require_once($controllerFile);
		}

		$fullClassName = '\BASE\Controller\\' . $class;

		$Controller = new $fullClassName($localCode);

		return ($Controller->$fct($regExpMatches)) ? true : false;
	}
}
