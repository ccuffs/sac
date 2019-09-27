<?php

namespace App\Helpers;

class View {
	private static $mBaseUrl = 'App/Views/';
	private static $mData;

	public static function data() {
		return self::$mData;
	}
	
	public static function baseUrl() {
		return BASE_URL;
	}
	
	public static function render($file, $data = []) {
		extract($data);
		self::$mData = $data;
		
		$view_file = dirname(__FILE__).'/../../'.self::$mBaseUrl.'/'.$file.'.php';
		require_once $view_file;
	}
}

?>