<?php

class Diffbot
{
	public static function get($url)
	{
		$result = DB::select('*')->from('api_diffbot')->where('api_diffbot_url', '=', $url)->execute();
		
		if(count($result) > 0)
		{
			$row = $result->current();
			try
			{
				$diff_result = unserialize($row['api_diffbot_result']);
				return array('api_diffbot_id' => $row['api_diffbot_id'], 'result' => unserialize($row['api_diffbot_result']));
			}
			catch(Exception $e)
			{
				return array('api_diffbot_id' => $row['api_diffbot_id'], 'result' => array("error" => "Parse Error"));
			}
		}
		
		$base_url = 'http://www.diffbot.com/api/article?';
		
		$query = array(
			'token' => '6cac419250318a4b8578eb077226ec0b',
			'url' => $url,
			'tags' => 1,
			'summary' => 1,
			'stats' => 1,
		);
		
		$request_url = $base_url.http_build_query($query);
		
		try
		{
			$raw = file_get_contents($request_url);
			$request_result = json_decode($raw);
		}
		catch(Exception $e)
		{
			return array('api_diffbot_id' => 0, 'result' => array("error" => "Fetch Error"));
		}
		
		list($insert_id, $total_rows) = DB::insert('api_diffbot', array(
				'api_diffbot_url',
				'api_diffbot_result_raw',
				'api_diffbot_result',
				'api_diffbot_created',
			))->values(array(
				$url,
				$raw,
				serialize($request_result),
				date('Y-m-d H:i:s'),
			))
			->execute()
			;
		
		return array('api_diffbot_id' => $insert_id, 'result' => $request_result);
	}
}