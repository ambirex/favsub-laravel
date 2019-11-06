<?php

class Controller_Strib extends Controller {

	public function action_index() {
		
		$k = 1;
		$last_odd = 1;
		echo "<style>div { border: 1px solid black; margin-bottom: 2px; }</style>";
		for($i = 0; $i < 9; $i++) {
			$is_odd = $k % 3;
			if($is_odd == 1) {
				echo '<div>';
			}
			echo $i.'<br>';
			if($is_odd == 0) {
				echo '</div>';
			}
			
			$last_odd = $is_odd;
			$k++;
		}
		
		if($last_odd == 1) {
			echo '</div>';
		}
	}
	
	public function action_index_new()
	{
		$bookmarks = Model_Item::lookup();
		
		$view = new View('bookmarks');
		$view->bookmarks = $bookmarks;
		echo $view;
	}
	
	public function action_index_old()
	{
		
		require Kohana::find_file('vendor', 'simplepie.inc.mine');
		
		$result = DB::query(Database::SELECT, "SELECT * FROM strib_feeds ORDER BY RAND() LIMIT 1")->execute();
		
		$row = $result->current();
		
		$feed = new SimplePie();
		$feed->set_feed_url($row['url']);
		$feed->enable_cache(false);
		$feed->init();
		$feed->handle_content_type();
		
		$items = array();
		
		$i = 0;
		foreach($feed->get_items() as $item)
		{
			$items[$i] = array(
				'title' => $item->get_title(),
				'date' => $item->get_date(),
				'content' => $item->get_content(),
				'link' => $item->get_link(),
				'permalink' => $item->get_permalink(),
			);
			
			$diffbot_url = 'http://www.diffbot.com/api/article?'. http_build_query(array('token' => '6cac419250318a4b8578eb077226ec0b', 'url' => $item->get_permalink(), 'tags' => 1, 'stats' => 1));
			$items[$i]['diffbot_url'] = $diffbot_url;
			
			$json_str = file_get_contents($diffbot_url);
			$json_data = json_decode($json_str);
			$items[$i]['diffbot'] = $json_data;
			
			$i++;
			
			sleep(1);
			
			if($i > 3) { break; }
		}
		
		echo "<pre>"; print_r($items); echo "</pre>";
		
	}
}