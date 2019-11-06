<?php
/*
 * Untested
 * Try and hang-up the client connection an continue processing, good for long running scripts
 */

class Hangup {
	
	static $has_ob_started = FALSE;

	public static function start_capture()
	{
		Hangup::$has_ob_started = TRUE;
		ob_start();
	}

	public static function client()
	{
		set_time_limit(0);
		
		# tell the client the request has finished processing
		header('Connection: close');
		
		@ob_end_clean(); #seems to complain a lot w/o the @
		
		# continue running once client disconnects
		ignore_user_abort();
		
		if(TRUE != Hangup::$has_ob_started) {
			ob_start();
		}
		
		$size = ob_get_length();
		header("Content-Length: $size");
		@ob_end_flush();
		flush();
		session_write_close();
	}
}