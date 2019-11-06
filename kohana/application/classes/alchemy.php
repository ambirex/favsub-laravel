<?php

class Alchemy {

	public $_api_key = 'a98277c5d534835e60cc66f109690c6066c79d98';
	
	public static function get_story_entities($story_id)
	{
		$result = DB::select('*')->from('api_alchemy')->where('item_id', '=', $story_id)->execute();
		
		if(count($result) > 0)
		{
			$row = $result->current();
			return array('api_alchemy_id' => $row['api_alchemy_id'], 'data' => unserialize($row['api_alchemy_result']));
		}
		
		include_once Kohana::find_file('vendor', 'alchemyapi/AlchemyAPIParams');
		include_once Kohana::find_file('vendor', 'alchemyapi/AlchemyAPI_CURL');
		
		//$result = DB::select('*')->from('items')->where('item_id', '=', $story_id)->execute();
		//$story = $result->current();
		$diffbot = Diffbot::get('http://smashinghub.com/beware-of-the-tricks-used-by-clients-to-manipulate-freelancers.htm');

		// Create an AlchemyAPI object.
		$alchemyObj = new AlchemyAPI();
		
		$_api_key = 'a98277c5d534835e60cc66f109690c6066c79d98';
		
		$alchemyObj->setAPIKey($_api_key);
		
		// Create a named entity API parameters object	
		$namedEntityParams = new AlchemyAPI_NamedEntityParams();
		
		// Turn off quotations extraction
		$namedEntityParams->setQuotations(0);
		
		// Turn off entity disambiguation
		$namedEntityParams->setDisambiguate(0);
		
		// Turn on sentiment analysis
		$namedEntityParams->setSentiment(1);
		
		$result = $alchemyObj->TextGetRankedNamedEntities($diffbot['result']->text, AlchemyAPI::JSON_OUTPUT_MODE, $namedEntityParams);
		
		$json = json_decode($result);
		
		list($api_alchemy_id, $aff_rows) = DB::insert('api_alchemy', array('item_id', 'api_alchemy_result_raw', 'api_alchemy_result', 'api_alchemy_created'))
			->values(array(
				$story_id,
				serialize($result),
				serialize($json),
				date('Y-m-d H:i:s'),
			))
			->execute()
			;
		
		return array('api_alchemy_id' => $api_alchemy_id, 'data' => $json);
	}
	
	public static function get_entity_id($entity_name, $entity_type)
	{
		$result = DB::select('*')->from('alchemy_entities')->where('al_entity_name', '=', $entity_name)->where('al_entity_type', '=', $entity_type)->execute();
		
		if(count($result) > 0)
		{
			$row = $result->current();
			return $row['al_entity_id'];
		}
		
		list($entity_id, $affected_rows) = DB::insert('alchemy_entities', array('al_entity_name', 'al_entity_type'))->values(array($entity_name, $entity_type))->execute();
		
		return $entity_id;
	}
	
	public static function tag_item($item_id)
	{
		$results = Alchemy::get_story_entities($item_id);
		
		DB::delete('alchemy_entity_members')->where('item_id', '=', $item_id)->execute();
		
		if(isset($results['data']->entities))
		{
			foreach($results['data']->entities as $entity)
			{
				$entity_id = Alchemy::get_entity_id($entity->text, $entity->type);
				
				$insert_array = array(
					'al_entity_id' => $entity_id,
					'item_id' => $item_id,
					'al_relevance' => $entity->relevance,
					'al_sentiment' => null,
					'al_sentiment_relevance' => null,
				);
				
				if(isset($entity->sentiment))
				{
					if(isset($entity->sentiment->type))
					{
						$insert_array['al_sentiment'] = $entity->sentiment->type;
					}
					
					if(isset($entity->sentiment->score))
					{
						$insert_array['al_sentiment_relevance'] = $entity->sentiment->score;
					}
				}
				
				DB::insert('alchemy_entity_members', array_keys($insert_array))->values($insert_array)->execute();
			}
		}
		
		DB::update('source_items')->set(array('api_alchemy_id' => $results['api_alchemy_id']))->where('item_id', '=', $item_id)->limit(1)->execute();
	}
}