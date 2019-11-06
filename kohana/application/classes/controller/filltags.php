<?php

class Controller_Filltags extends Controller {

	public function action_index()
	{
		$result = DB::select('i.*', 'u.url')
					->from(array('items', 'i'))
					->join(array('urls', 'u'))
						->on('u.id', '=', 'i.item_url_id')
					->limit(100)
					->where('i.api_diffbot_id', '=', NULL)
					//->offset(15500)
					->execute()
					;
		
		echo '<pre>'; print_r($result); echo '</pre>';
		
		foreach($result as $item)
		{
			$tag_result = DB::select('*')
							->from(array('tag_members', 'tm'))
							->join(array('tags', 't'))
								->on('t.id', '=', 'tm.tag_id')
							->where('tm.item_id', '=', $item['id'])
							->execute()
							;
			
			$item['tags'] = array();
							
			$tags = array();
			foreach($tag_result as $tag)
			{
				$tag_id = $tag['tag_id'];
				$tag_name = $tag['name'];
				$item['tags'][$tag_id] = $tag_name;
			}
			
			$diffbot = Diffbot::get($item['url']);
			echo '<pre>'; print_r($diffbot); echo '</pre>';
			
			$tagged_manual = 0;
			if(count($item['tags']) > 0)
			{
				$tagged_manual = 1;
			}
			
			if(isset($diffbot['result']->errorCode))
			{
				if($diffbot['result']->errorCode == '404')
				{
					if( ! in_array('404', $item['tags']))
					{
						$item['tags'][] = '404';
					}
				}
			}
			
			if(isset($diffbot['result']->tags))
			{
				foreach($diffbot['result']->tags as $diff_tag)
				{
					$diff_tag = preg_replace('/,/', '', $diff_tag);
					if( ! in_array($diff_tag, $item['tags']))
					{
						$item['tags'][] = $diff_tag;
					}
				}
			}
			
			Model_Item::edit($item['id'], $item['title_full'], $item['url'], $item['tags'], $item['content'], $tagged_manual, $diffbot['api_diffbot_id']);
			
			echo '<pre>'; print_r($item); echo '</pre>';
			sleep(1);
		}
	}
}