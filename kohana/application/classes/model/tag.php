<?php

class Model_Tag extends Model {

	public static function get_id($tag_name, $insert_new = TRUE)
	{
		$result = DB::select('*')->from('tags')->where('name', 'LIKE', $tag_name)->execute();
		
		if(count($result) > 0)
		{
			$row = $result->current();
			return $row['id'];
		}
		else if($insert_new)
		{
			list($insert_id, $total_rows) = DB::insert('tags', array('name'))->values(array($tag_name))->execute();
			return $insert_id;
		}
		
		return FALSE;
	}

	public static function add_member($tag_name, $item_id)
	{
		$tag_id = self::get_id($tag_name);
		
		$result = DB::select('*')
					->from('tag_members')
					->where('tag_id', '=', $tag_id)
					->where('item_id', '=', $item_id)
					->execute()
					;
					
		if(count($result) > 0)
		{
			return true;
		}
		
		DB::insert('tag_members', array('tag_id', 'item_id'))->values(array($tag_id, $item_id))->execute();
		
		return true;
	}
	
	public static function clear_member_tags($item_id)
	{
		$result = DB::delete('tag_members')
					->where('item_id', '=', $item_id)
					->execute()
					;
					
		return true;
	}
	
	public static function get_tag_list($return_more_than = 1)
	{
		$result = DB::select('tags.*')
			->select(array('COUNT("id")', 'cnt'))
			->from('tags')
			->join('tag_members')
				->on('tags.id', '=', 'tag_members.tag_id')
			->group_by('tags.id')
			->order_by('cnt', 'DESC')
			->execute();
			
		$return = array();
		foreach($result as $row) {
			if($row['cnt'] > $return_more_than) {
				$return[] = $row;
			}
		}
		
		return $return;
	}
	
	public static function get_simple_list($return_more_than = 0)
	{
		$result = DB::select('tags.*')
			->select(array('COUNT("id")', 'cnt'))
			->from('tags')
			->join('tag_members')
				->on('tags.id', '=', 'tag_members.tag_id')
			->group_by('tags.id')
			->order_by('cnt', 'DESC')
			->execute();
			
		$return = array();
		foreach($result as $row) {
			if($row['cnt'] > $return_more_than) {
				$return[] = $row['name'];
			}
		}
		
		return $return;
	}
}