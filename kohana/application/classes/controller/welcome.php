<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
		echo "<a href='/bookmarks'>Bookmarks</a>";
	}

} // End Welcome
