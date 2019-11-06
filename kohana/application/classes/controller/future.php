<?php

class Controller_Future extends Controller {

	public function action_index()
	{
		$view = new View('template');
		$view->logged_in = FALSE;

		$view->js_files = array('js/future.js');

		$view->body = new View('strtotime');

		echo $view;
	}

	public function action_strtotime()
	{
		if(isset($_GET['term'])) {
			$unix_time = strtotime(trim($_GET['term']));

			$retarr = array(
					array(
							'value' => date('Y-m-d H:i:s', $unix_time),
							'label' => date('F j, Y, g:i a', $unix_time)
						),
				);

			echo json_encode($retarr);
		}
	}
}