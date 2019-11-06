<?php

class Controller_Zf extends Controller {

	public function action_index()
	{
		$test_str = '2012-08-31T19:00:00-05:00';
		$zdate = new Zend_Date($test_str, Zend_Date::ISO_8601);
		echo '<pre>';
		print_r($zdate->setTimeZone('America/Chicago')->toString('h:mm a'));
		echo '</pre>';
	}
}