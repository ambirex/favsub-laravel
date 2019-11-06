<?php

class Model_Item extends Model {

	const SOURCE_TYPE_BOOKMARK = 1;
	const SOURCE_TYPE_FEED = 2;
	
	public static function lookup($query = array(), $item_page = 1, $items_per_page = 25)
	{
		$item_found_count = 0;
		
		$select = DB::select('items.*')
					->from('items')
					->join('tag_members', 'LEFT')
						->on('items.id', '=', 'tag_members.item_id')
					;
		
		$query['logged_in'] = (isset($query['logged_in'])) ? $query['logged_in'] : FALSE;
		
		if(FALSE == $query['logged_in']) {
			//$select->where('tag_members.tag_id', 'NOT IN', array(9, 1170));
			$query['not_tag_id'] = array(9, 1170);
		}
		
		if(isset($query['text']))
		{
			$search_query = $query['text'];
			$select->where('items.title_short', 'LIKE', "%$search_query%");
			$select->or_where('items.content', 'LIKE', "%$search_query%");
		}
		
		if(isset($query['id']))
		{
			$item_id = (int) $query['id'];
			if($item_id > 0)
			{
				$select->where('items.id', '=', $item_id);
			}
		}
		
		if(isset($query['not_id']))
		{
			$item_id = (int) $query['not_id'];
			if($item_id > 0)
			{
				$select->where('items.id', '!=', $item_id);
			}
		}
		
		if(isset($query['tag_id']))
		{
			$tag_id = (int) $query['tag_id'];
			if($tag_id > 0)
			{
				$select->where('tag_members.tag_id', '=', $tag_id);
			}
		}
		
		if(isset($query['not_tag_id']))
		{
			if(is_array($query['not_tag_id']))
			{
				$sub_select = DB::select('item_id')->from('tag_members')->where('tag_id', 'IN', array(9, 1170));
				$select->where('items.id', 'NOT IN', $sub_select);
			}
		}
		
		if(isset($query['tagless']))
		{
			$select->where('tag_members.tag_id', '=', NULL);
		}
		
		if(isset($query['time']))
		{
			$select->where('HOUR("items.entered_date")', '=', $query['time']['h']);
			$select->where('MINUTE("items.entered_date")', '=', $query['time']['m']);
		}
		
		$total_select = clone $select;
		$total_select->select(array('COUNT(DISTINCT "items.id")', 'item_count'));
		$results = $total_select->execute();
		//echo '<pre>'; print_r($results); echo '</pre>';
		$row = $results->current();
		$item_found_count = $row['item_count'];
		
		$item_offset = ($item_page - 1) * $items_per_page;
		$select->limit($items_per_page)
				->offset($item_offset)
				->group_by('items.id')
				->order_by('items.entered_date', 'DESC')
				;
		
		$results = $select->execute();
		
		$url_ids = array(0 => 0);
		$urls = array();
		$tags = array();
		$bookmarks = array();
		$bookmark_ids = array(0 => 0);
		foreach($results as $row)
		{
			$row['tags'] = array();
			$bookmarks[$row['id']] = $row;
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
		
		$results = DB::select('*')
					->from('tag_members')
					->join('tags')
						->on('tag_members.tag_id', '=', 'tags.id')
					->where('tag_members.item_id', 'IN', $bookmark_ids)
					->execute()
					;
		
		foreach($results as $row)
		{
			$bookmarks[$row['item_id']]['tags'][$row['tag_id']] = $row;
		}
		
		$item_page_count = ceil($item_found_count / $items_per_page);
		
		return array('items' => $bookmarks, 'urls' => $urls, 'item_found_count' => $item_found_count, 'items_per_page' => $items_per_page, 'item_page_count' => $item_page_count, 'item_page' => $item_page);
	}
	
	public static function edit($id, $title, $url, $tags, $content = '', $tagged_manual = 0, $diffbot_id = FALSE)
	{
		$update_array = array(
						'title_short'   => $title,
						'title_full'    => $title,
						'item_url_id'   => Model_Url::get_id($url),
						'content'       => $content,
						'tagged_manual' => $tagged_manual,
					);
		
		if($diffbot_id)
		{
			$update_array['api_diffbot_id'] = $diffbot_id;
		}
		
		$result = DB::update('items')
					->set($update_array)
					->where('id', '=', $id)
					->limit(1)
					->execute()
					;
					
		Model_Tag::clear_member_tags($id);
		
		if(is_array($tags))
		{
			foreach($tags as $tag)
			{
				Model_Tag::add_member($tag, $id);
			}
		}
		
		return true;
	} 
	
	public static function legacy_add($data)
	{
		$result = DB::select('*')
					->from('items')
					->where('legacy_id', '=', $data['id'])
					->execute();
		
		if(count($result) > 0)
		{
			$row = $result->current();
			return $row['id'];
		}
		
		$insert_data = array(
			'item_type' => self::SOURCE_TYPE_BOOKMARK,
			'item_source_id' => 1,
			'item_url_id' => Model_Url::get_id($data['url']),
			'ref_url_id' => Model_Url::get_id($data['reference']),
			'title_short' => $data['title'],
			'title_full' => $data['title'],
			'content' => $data['content'],
			'legacy_id' => $data['id'],
			'entered_date' => $data['entered_date'],
		);
		
		list($insert_id, $total_rows) = DB::insert('items', array_keys($insert_data))->values($insert_data)->execute();
		
		return $insert_id;
	}
	
	public static function add($data)
	{
		$insert_data = array(
			'item_type' => self::SOURCE_TYPE_BOOKMARK,
			'item_source_id' => 1,
			'item_url_id' => Model_Url::get_id($data['url']),
			'title_short' => $data['title'],
			'title_full' => $data['title'],
			'content' => $data['content'],
			'entered_date' => date("Y-m-d H:i:s"),
		);
		
		if(isset($data['reference']))
		{
			$insert_data['ref_url_id'] = Model_Url::get_id($data['reference']);
		}
		
		list($insert_id, $total_rows) = DB::insert('items', array_keys($insert_data))->values($insert_data)->execute();
		
		return $insert_id;
	}
	
	public static function delete($id)
	{
		$result = DB::delete('items')
					->where('id', '=', $id)
					->execute()
					;
					
		return true;
	}
}