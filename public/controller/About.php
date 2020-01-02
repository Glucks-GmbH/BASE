<?php

namespace BASE\Controller;

use BASE\MVC\TemplateEngines\Smarty\ParentController;

class About extends ParentController
{
	public function overview()
	{
		$this->displayTemplates(__FUNCTION__);
	}

	public function history()
	{
		echo "<h1>About history</h1>";
	}
}
