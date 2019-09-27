<?php

namespace App\Helpers;

class RequestHelper {
    public static function get ($url, $options = []) {
        $ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
    
        if (isset($options['headers'])) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $options['headers']);
        }
		
		// Submit the POST request
		$result = curl_exec($ch);
		
		// Close cURL session handle
        curl_close($ch);
        return $result;
    }

    public static function post ($url, $data = [], $options = []) {
        $data = json_encode($data);
        $ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		// Set HTTP Header for POST request 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data))
		);
		
		// Submit the POST request
		$result = curl_exec($ch);
		
		// Close cURL session handle
        curl_close($ch);
        return $result;
    }
}