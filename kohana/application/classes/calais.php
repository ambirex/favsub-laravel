<?php

class Calais {

	public static function tag_item($item_id)
	{
		$entities = Calais::getEntities($item_id);
		
		DB::delete('entity_members')->where('item_id', '=', $item_id)->execute();
		
		foreach($entities as $entity_type => $entity_values)
		{
			foreach($entity_values as $entity_name)
			{
				$entity_id = Calais::get_entity_id($entity_name, $entity_type);
				DB::insert('entity_members', array('entity_id', 'item_id'))->values(array($entity_id, $item_id))->execute();
			}
		}
		
		DB::update('source_items')->set(array('calais_fetched' => 1))->where('item_id', '=', $item_id)->limit(1)->execute();
	}
	
	public static function get_entity_id($entity_name, $entity_type)
	{
		$result = DB::select('*')->from('entities')->where('entity_name', '=', $entity_name)->where('entity_type', '=', $entity_type)->execute();
		
		if(count($result) > 0)
		{
			$row = $result->current();
			return $row['entity_id'];
		}
		
		list($entity_id, $affected_rows) = DB::insert('entities', array('entity_name', 'entity_type'))->values(array($entity_name, $entity_type))->execute();
		
		return $entity_id;
	}
	
	public static function getEntities($item_id)
	{
		$result = DB::select('*')->from('calais_cache')->where('item_id', '=', $item_id)->execute();
		
		if(count($result) > 0)
		{
			$row = $result->current();
			return unserialize($row['entities']);
		}
		
		$result = DB::select('*')->from('source_items')->where('item_id', '=', $item_id)->execute();
		$row = $result->current();
		
		$apikey = "xyg77kpjkhstwpke2yhmwg4b";
		$oc = new OpenCalais($apikey);
		
		$entities = $oc->getEntities($row['item_content']);
		
		DB::insert('calais_cache', array('item_id', 'entities', 'entered'))->values(array($item_id, serialize($entities), date('Y-m-d H:i:s')))->execute();
		
		return $entities;
	}
}