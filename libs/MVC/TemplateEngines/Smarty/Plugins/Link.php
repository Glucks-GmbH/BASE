<?php
/**
 * Smarty Plugin Link to create uris directly inside the template
 *
 * @package        BASE
 * @subpackage     MVC
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 *
 */

namespace BASE\MVC\TemplateEngines\Smarty\Plugins;

use BASE\MVC\Links;
use RuntimeException;

/**
 * Class Link
 *
 * @package        BASE\MVC\TemplateEngines\Smarty\Plugins
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 */
class Link
{
	/**
	 * Returns the uri by the controller.
	 *
	 * @param array $parameters ['controller' => string, 'values' => [string, string]]
	 *
	 * @return string
	 */
	public function get(array $parameters)
	{
		if (!is_array($parameters['values'])) {
			$parameters['values'] = [];
		}

		$uri = Links::getUri($parameters['controller'], $parameters['values']);

		if (!$uri) {
			throw new RuntimeException("Unknown controller: " . $parameters['controller'], E_ERROR);
		} else {
			return $uri;
		}
	}

	/**
	 * Returns an array to build a breadcrumb
	 *
	 * @param array $parameters ['controller' => string, 'values' => [string, string]]
	 *
	 * @return array
	 */
	public function getBreadcrumb(array $parameters)
	{

	}
}
