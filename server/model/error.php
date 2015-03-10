<?php

class Error {

	public static function write($message, $line, $class){
		
		$time = date("Y-m-d H:i:s");
		
		$text = "$time :: $message :: $line :: $class \n"; // Rides string

		$handler = fopen('./log.txt', 'a'); // add to the end of file
		fwrite($handler, $text);
		fclose($handler);
	}

}