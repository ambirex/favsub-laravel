<?php

class Model_Url extends Model {
	
	public static function get_id($url)
	{	
		if(empty($url)) {
			return 0;
		}
		
		$hash = sha1($url);
		$result = DB::select('*')->from('urls')->where('hash', '=', $hash)->execute();
		
		if(count($result) > 0)
		{
			$row = $result->current();
			return $row['id'];
		} else {
			$url_parts = parse_url($url);
			$domain_id = Model_Domain::get_id($url_parts['host']);
			list($insert_id, $total_rows) = DB::insert('urls', array('domain_id','url','hash'))->values(array($domain_id, $url, $hash))->execute();
			return $insert_id;
		}
		
		return FALSE;
	}
	
	public static function cleanup($url)
	{
		$bad_query_vars = array(
			'utm_source',
			'utm_medium',
			'utm_campaign',
		);
		
		$parsed_url = parse_url($url);
		
		$query = FALSE;
		if(isset($parsed_url['query']))
		{
			parse_str($parsed_url['query'], $query);
			foreach($query as $key => $value)
			{
				if(in_array($key, $bad_query_vars))
				{
					unset($query[$key]);
				}
			}
			
			if(count($query) == 0)
			{
				$query = FALSE;
			}
		}
		
		$scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
		$host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
		$port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
		$user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
		$pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
		$pass     = ($user || $pass) ? "$pass@" : '';
		$path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
		$query    = ($query) ? '?' . http_build_query($query, '', '&') : '';
		$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
		
		return "$scheme$user$pass$host$port$path$query$fragment";
	}
}