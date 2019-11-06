<?php

class Controller_Monkey extends Controller {

	public function action_index()
	{
		if(isset($_GET['callback']))
		{
			$result = DB::select("*")->from('social_sites')->where('social_knowem_path', 'LIKE', $_GET['social_knowem_path'])->execute();
			
			if(count($result) < 1)
			{
				die();
			}
			
			$site = $result->current();
			
			try
			{
			$input_array = array(
				'social_site_name' => $_GET['social_site_name'],
				'social_site_category' => $_GET['social_site_category'],
				'social_site_url' => $_GET['social_site_url'],
				'social_site_desc' => (isset($_GET['social_site_desc'])) ? $_GET['social_site_desc'] : '',
				'social_site_alexa_rank' => $_GET['social_site_alexa_rank'],
				'social_site_compete_rank' => $_GET['social_site_compete_rank'],
				'social_site_compete_volume' => $_GET['social_site_compete_volume'],
				'social_site_majestic_domains' => $_GET['social_site_majestic_domains'],
				'social_site_majestic_links' => $_GET['social_site_majestic_links'],
				'scoial_knowem_scraped' => 1,
			);
			} catch(Exception $e) {
				echo '<pre>'; print_r($_GET); echo '</pre>';
				die();
			}
			DB::update('social_sites')->set($input_array)->where('social_site_id', '=', $site['social_site_id'])->execute();
			
			DB::delete('social_site_tag_members')->where('social_site_id', '=', $site['social_site_id'])->execute();
			
			if(isset($_GET['tags']))
			{
				foreach($_GET['tags'] as $tag)
				{
					$tag_result = DB::select('*')->from('social_site_tags')->where('social_site_tag_name', '=', $tag)->execute();
					
					if(count($tag_result) == 0)
					{
						list($tag_id, $aff_rows) = DB::insert('social_site_tags', array('social_site_tag_name'))->values(array($tag))->execute();
					}
					else
					{
						$curr_tag = $tag_result->current();
						$tag_id = $curr_tag['social_site_tag_id'];
					}
					
					DB::insert('social_site_tag_members', array('social_site_id', 'social_site_tag_id'))->values(array($site['social_site_id'], $tag_id))->execute();
				}
			}
			
			$next_url_result = DB::select('*')->from('social_sites')->where('scoial_knowem_scraped', '=', 0)->limit(1)->execute();
			
			if(count($next_url_result) > 0)
			{
				$next_site = $next_url_result->current();
				$_GET['next_url'] = 'http://knowem.com'.$next_site['social_knowem_path'];
			}
			else
			{
				$_GET['next_url'] = 'nope';
			}
			
			echo $_GET['callback'] . '('.json_encode($_GET).')';
		}
	}
}