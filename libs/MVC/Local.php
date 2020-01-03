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

use BASE\Config;

/**
 * Class to get the local information from uri or config.
 *
 * @package        BASE\MVC
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 */
class Local
{
	/**
	 * Returns the language-country code from uri or config. Checks if the uri code is allowed by the config.
	 *
	 * @return string|null
	 */
	public static function getCode()
	{
		$uriLocalCode = Uri::getLocalCode();
		if (!empty($uriLocalCode)) {
			$allowedLocalCodes = Config::getHostParameter("allowedLocalCodes");
			if (is_object($allowedLocalCodes)) {
				foreach ($allowedLocalCodes->localCode as $localCode) {
					if ($uriLocalCode == (string)$localCode) {
						return $uriLocalCode;
					}
				}
			}
			return null;
		} else {
			return Config::getHostParameter("localCode");
		}
	}
}
