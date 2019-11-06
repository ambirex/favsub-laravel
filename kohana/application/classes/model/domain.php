<?php

class Model_Domain extends Model {
	
	public static function get_id($domain) {
		
		$result = DB::select('*')->from('domains')->where('domain', '=', $domain)->execute();
		
		if(count($result) > 0)
		{
			$row = $result->current();
			return $row['id'];
		} else {
			list($insert_id, $total_rows) = DB::insert('domains', array('domain'))->values(array($domain))->execute();
			return $insert_id;
		}
		
		return FALSE;
	}
}