<?php
abstract class Controller_Api_Base extends Controller_Base {

	public function check_param($param) {
		$params = explode ( ',', $param );
		foreach ( $params as $param ) {
			if (Util_Server_Request::get_request ( trim ( $param ) ) === '') {
				return 0;
			}
		}
		return 1;
	}

	public function replace_param($subject, $package = 0, $extend = '') {
		preg_match_all ( '/\$\{param:(\w+)\}/', $subject, $matches );
		foreach ( array_unique ( $matches [1] ) as $match ) {
			$config = M ( 'Conf' )->get_by_keyword ( $package, 'param', $match );
			$subject = preg_replace ( '/\$\{param:' . $match . '\}/', $config ['value'], $subject );
		}
		if ($extend) {
			preg_match_all ( '/\$\{extend:global\}/', $subject, $matches );
			foreach ( array_unique ( $matches [0] ) as $match ) {
				$subject = preg_replace ( '/\$\{extend:global\}/', $extend, $subject );
			}
			preg_match_all ( '/\$\{extend:json:((\w+)(:\w+)*)\}/', $subject, $matches );
			if ($matches [1]) {
				$json = @json_decode ( $extend );
				if (! is_null ( $json )) {
					foreach ( array_unique ( $matches [1] ) as $match ) {
						$value = '';
						@eval ( '$value = $json->{"' . preg_replace ( '/:/', '"}->{"', $match ) . '"};' );
						$value = is_array ( $value ) ? implode ( ", ", $value ) : $value;
						$subject = preg_replace ( '/\$\{extend:json:' . preg_replace ( '/\//', '\/', preg_quote ( $match ) ) . '\}/', $value, $subject );
					}
				}
			}
			preg_match_all ( '/\$\{extend:xml:([^;]+);\}/', $subject, $matches );
			if ($matches [1]) {
				$xml = @simplexml_load_string ( $extend );
				if ($xml) {
					foreach ( array_unique ( $matches [1] ) as $match ) {
						$value = @$xml->xpath ( $match );
						$value = is_array ( $value ) ? implode ( ", ", $value ) : $value;
						$subject = preg_replace ( '/\$\{extend:xml:' . preg_replace ( '/\//', '\/', preg_quote ( $match ) ) . ';\}/', $value, $subject );
					}
				}
			}
		}
		return $subject;
	}

	public function get_header($response) {
		$header = '';
		while ( preg_match ( '/^HTTP\//', $response ) ) {
			$response = explode ( "\r\n\r\n", $response, 2 );
			if (count ( $response ) >= 2) {
				$header .= $response [0] . "\r\n\r\n";
				$response = $response [1];
			}
		}
		return array (
				'header' => $header,
				'response' => $response 
		);
	}

	public function get_cookie($file = '') {
		$saved_file = Util_Server_Request::get_cookie ( 'cookiefile' );
		if ($saved_file) {
			$file = $saved_file;
		} else {
			$file = $file ? $file : 'local-' . microtime ();
			Util_Client_Cookie::set_cookie ( 'cookiefile', $file, time () + 90 * 24 * 3600 );
		}
		return APP_PATH . '/tmp/cookie/' . $file;
	}

	public function set_curl($type, $url, $param, $header, $cookie = '', $option = 0) {
		$ch = curl_init ();
		$cookie = $this->get_cookie ( $cookie );
		
		switch ($type) {
			case 'GET' :
				$param && $url .= '?' . $param;
				break;
			case 'POST' :
				curl_setopt ( $ch, CURLOPT_POST, true );
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );
				break;
			case 'PUT' :
				curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "PUT" );
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );
				break;
			case 'DELETE' :
				curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );
				break;
		}
		
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, $option );
		curl_setopt ( $ch, CURLOPT_COOKIEFILE, $cookie );
		curl_setopt ( $ch, CURLOPT_COOKIEJAR, $cookie );
		$response = curl_exec ( $ch );
		$return = $option ? json_encode ( array_merge ( $this->get_header ( $response ), array (
				'code' => curl_getinfo ( $ch, CURLINFO_HTTP_CODE ),
				'time' => curl_getinfo ( $ch, CURLINFO_TOTAL_TIME ) 
		) ) ) : $response;
		curl_close ( $ch );
		return $return;
	}
}