<?php

require_once dirname(__FILE__).'/config.php';

class View {
	private static $mBaseUrl;
	private static $mData;

	public static function data() {
		return self::$mData;
	}
	
	public static function baseUrl() {
		return self::$mBaseUrl;
	}
	
	public static function render($theFile, $theData = array(), $theOutput = 'html') {
		self::$mBaseUrl = 'view/'.$theOutput;
		self::$mData 	= $theData;
		
		require_once dirname(__FILE__).'/../'.self::$mBaseUrl.'/'.$theFile.'.php';
	}
}

?>