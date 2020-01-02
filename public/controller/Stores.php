<?php

namespace BASE\Controller;

use BASE\MVC\TemplateEngines\Smarty\ParentController;

class Stores extends ParentController
{
	public function overview()
	{
		$this->displayTemplates(__FUNCTION__);
	}

	public function details($regExpMatches)
	{
		$this->Smarty->assign("storeName", $regExpMatches[1]);

		$this->displayTemplates(__FUNCTION__);
	}
}
