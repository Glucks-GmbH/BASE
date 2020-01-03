<?php

namespace BASE\Controller;

use BASE\MVC\TemplateEngines\Smarty\ParentController;

class Website extends ParentController
{
	public function homepage()
	{
		$this->displayTemplates(__FUNCTION__);
	}
}
