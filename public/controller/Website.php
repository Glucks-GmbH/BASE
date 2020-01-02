<?php

namespace BASE\Controller;

use BASE\MVC\Links;

class Website
{
	public function homepage()
	{
		echo "<h1>Hallo Homepage</h1>";

		echo '<a href="' . Links::getUri('/About::overview') . '">About</a>';
	}
}
