<?php

namespace App\Helpers;

class View {
	private static $mBaseUrl;
	private static $mData;

	public static function data() {
		return self::$mData;
	}
	
	public static function baseUrl() {
		return self::$mBaseUrl;
	}
	
	public static function render($theFile, $theData = array()) {
		self::$mBaseUrl = 'view/';
		self::$mData 	= $theData;
		
		$view_file = dirname(__FILE__).'/../../'.self::$mBaseUrl.'/'.$theFile.'.php';

		require_once $view_file;
	}
}

?>