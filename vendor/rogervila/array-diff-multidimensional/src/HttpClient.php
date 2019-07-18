<?php 

namespace Rogervila; 

class HttpClient
{
	/**
	 * http请求方式: 默认GET
	 */
	public static function curl_http($request_url, $method="GET", $post_params){
	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_URL, $request_url);
		// curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		if (!empty($post_params)) {
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
		}
		//if result is not ok , retry one more time
		$result = curl_exec($ch);
		// echo $result;exit;
		$info = curl_getinfo($ch);
		$errno = curl_errno($ch);
		$error = curl_error($ch);
		curl_close($ch);
		return $result;
	}
	
}