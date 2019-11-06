<?php

class Controller_Fb extends Controller {

	public function action_index()
	{
		include_once Kohana::find_file('vendor', 'facebook/src/facebook');
		// Create our Facebook SDK instance.
		$facebook = new Facebook(array(
			'appId'  => Kohana::$config->load('facebook')->app_id, 
			'secret' => Kohana::$config->load('facebook')->secret, 
			'cookie' => true // enable optional cookie support
		));
		
		$facebook->setAccessToken('AAADrJJJmggMBAFWquykTXNL1MxrQZAFnY6oN0KBRRB02pZC71EfIJ0xLEDZADBKZBhsQ1d42WaICkOjY9p5fJiND4PDQ368ZD');
		$result = $facebook->api('/me/home');
		
		$types = array();
		foreach($result['data'] as $item) {
			$types[$item['type']] = $item['type'];
			if($item['type'] == 'status')
			{
				echo '<pre>'; print_r($item); echo '</pre>';
			}
		}
		
		echo "<pre>";
		print_r($types);
		echo "</pre>";
	}
	
	public function action_test()
	{
		$fb_timestamp = '2012-03-27T15:54:20+0000';
		$epochtime = strtotime($fb_timestamp);
		
		echo date("Y-m-d h:i:s", $epochtime) . '<br>' . $fb_timestamp;		
	}
}