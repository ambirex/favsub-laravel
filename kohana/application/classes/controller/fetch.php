<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Fetch extends Controller {

	public function action_index()
	{
		$result = DB::select(array('MAX("entered_date")', 'max_entered_date'))
					->from('items')
					->execute()
					;
		
		
		$row = $result->current();
		
		$result = DB::select('*')
					->from('incoming')
					//->limit(10, 10)
					->where('entered_date', '>=', $row['max_entered_date'])
					->execute('gtd')
					;
		
		foreach($result as $row)
		{
			//echo "<pre>"; print_r($row); echo "</pre>";
			$new_id = Model_Item::legacy_add($row);
			
			$tag_member_result = DB::select('*')->from('tag_member')->where('lruf_id', '=', $row['id'])->execute('gtd');
			foreach($tag_member_result as $tag_row)
			{
				$tag = DB::select('*')->from('tag')->where('tag_id', '=', $tag_row['tag_id'])->execute('gtd')->current();
				Model_Tag::add_member($tag['tag_name'], $new_id);
			}
			
			/*
			Model_Url::get_id($row['url']);
			if( ! empty($row['reference']))
			{
				Model_Url::get_id($row['reference']);
			}
			*/
		}
	}
	
	public function action_show()
	{
		$results = DB::select('*')
					->from('items')
					->order_by('entered_date', 'DESC')
					->limit(25)
					->execute()
					;
		
		$url_ids = array();
		$urls = array();
		$tags = array();
		$bookmarks = array();
		$bookmark_ids = array();
		foreach($results as $row)
		{
			$bookmarks[] = $row;
			$bookmark_ids[$row['id']] = $row['id'];
			$url_ids[$row['item_url_id']] = $row['item_url_id'];
			$url_ids[$row['ref_url_id']] = $row['ref_url_id'];
		}
		
		$results = DB::select('*')
					->from('urls')
					->where('id', 'IN', $url_ids)
					->execute()
					;
		
		foreach($results as $row)
		{
			$urls[$row['id']] = $row;
		}
		
		echo "<pre>"; print_r($urls); echo "</pre>";
	}
	
	public function action_index_old()
	{
		
		require Kohana::find_file('vendor', 'simplepie.inc.mine');
		
		$result = DB::query(Database::SELECT, "SELECT * FROM feeds ORDER BY RAND() LIMIT 1")->execute();
		
		$row = $result->current();
		
		$feed = new SimplePie();
		$feed->set_feed_url($row['url']);
		$feed->enable_cache(false);
		$feed->init();
		$feed->handle_content_type();
		
		$items = array();
		
		foreach($feed->get_items() as $item)
		{
			$items[] = array(
				'title' => $item->get_title(),
				'date' => $item->get_date(),
				'content' => $item->get_content(),
				'link' => $item->get_link(),
				'permalink' => $item->get_permalink(),
			);
		}
		
		echo "<pre>"; print_r($items); echo "</pre>";
		
	}

} // End Welcome
