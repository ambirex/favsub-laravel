<?php

class Controller_Posttit extends Controller {

	public function action_index()
	{
		$rclient = new Reddit("ambirex", "win95sux");
		$userData = $rclient->getUser();
		echo '<pre>'; print_r($userData); echo '</pre>';

		$post['link'] = 'https://github.com/jcleblanc/reddit-php-sdk';
		$post['title'] = 'Reddit PHP SDK';
		$post['subreddit'] = 'favsub';
		$response = $rclient->createStory($post['title'], $post['link'], $post['subreddit']);
		echo '<pre>'; print_r($response); echo '</pre>';		
	}
}
