<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;
use Lazybug\Framework\Util_Client_Cookie as Cookie;

/**
 * Controller 接口控制器基类
 */
abstract class Controller_Api_Base extends Controller_Base {

	public function check_param($param) {
		$params = explode ( ',', $param );
		foreach ( $params as $param ) {
			if (Request::get_request ( trim ( $param ) ) === '') {
				return 0;
			}
		}
		return 1;
	}

	public function set_system_param($subject, $package, $fliter) {
		preg_match_all ( '/\$\{param:(\w+)\}/', $subject, $matches );
		foreach ( array_unique ( $matches [1] ) as $match ) {
			$config = LF\M ( 'Conf' )->get_by_keyword ( $package, 'param', $match );
			$config ['value'] = isset ( $config ['value'] ) ? $config ['value'] : '[[ 配置不存在 ]]';
			$replacement = $fliter ? str_replace ( '"', '\\"', $config ['value'] ) : $config ['value'];
			$subject = preg_replace ( '/\$\{param:' . $match . '\}/', $replacement, $subject );
		}
		return $subject;
	}

	public function set_function_param($subject) {
		preg_match_all ( '/\$\{function:(rand\((\d+)\))\}/', $subject, $matches );
		foreach ( $matches [1] as $index => $match ) {
			$replacement = '';
			for($i = 0; $i < $matches [2] [$index]; $i ++) {
				$replacement .= rand ( 0, 9 );
			}
			$subject = preg_replace ( '/\$\{function:' . preg_quote ( $match ) . '\}/', $replacement, $subject, 1 );
		}
		preg_match_all ( '/\$\{function:(randc\((\d+)\))\}/', $subject, $matches );
		foreach ( $matches [1] as $index => $match ) {
			$replacement = '';
			for($i = 0; $i < $matches [2] [$index]; $i ++) {
				$replacement .= chr ( rand ( 97, 122 ) );
			}
			$subject = preg_replace ( '/\$\{function:' . preg_quote ( $match ) . '\}/', $replacement, $subject, 1 );
		}
		preg_match_all ( '/\$\{function:(time\(([sm])\))\}/', $subject, $matches );
		foreach ( $matches [1] as $index => $match ) {
			if ($matches [2] [$index] === 's') {
				$replacement = time ();
			} else {
				$times = explode ( ' ', microtime () );
				$replacement = strval ( $times [1] ) . substr ( strval ( round ( $times [0], 3 ) ), 2 );
			}
			$subject = preg_replace ( '/\$\{function:' . preg_quote ( $match ) . '\}/', $replacement, $subject, 1 );
		}
		return $subject;
	}

	public function set_extractor_param($subject, $extend, $fliter) {
		if (! $extend) {
			return $subject;
		}
		preg_match_all ( '/\$\{extractor:global\}/', $subject, $matches );
		foreach ( array_unique ( $matches [0] ) as $match ) {
			$replacement = $fliter ? str_replace ( '"', '\\"', $extend ) : $extend;
			$subject = preg_replace ( '/\$\{extractor:global\}/', $replacement, $subject );
		}
		preg_match_all ( '/\$\{extractor:json:([^;]+);\}/', $subject, $matches );
		if ($matches [1]) {
			$json = @json_decode ( $extend, true );
			if (! is_null ( $json )) {
				foreach ( array_unique ( $matches [1] ) as $match ) {
					$value = '';
					@eval ( '$value = $json[\'' . preg_replace ( '/\->/', '\'][\'', $match ) . '\'];' );
					$value = is_array ( $value ) ? implode ( ", ", $value ) : $value;
					$replacement = $fliter ? str_replace ( '"', '\\"', $value ) : $value;
					$subject = preg_replace ( '/\$\{extractor:json:' . preg_replace ( '/\//', '\/', preg_quote ( $match ) ) . ';\}/', $replacement, $subject );
				}
			}
		}
		preg_match_all ( '/\$\{extractor:xml:([^;]+);\}/', $subject, $matches );
		if ($matches [1]) {
			$xml = @simplexml_load_string ( $extend );
			if ($xml) {
				foreach ( array_unique ( $matches [1] ) as $match ) {
					$value = '';
					$value = @$xml->xpath ( $match );
					$value = is_array ( $value ) ? implode ( ", ", $value ) : $value;
					$replacement = $fliter ? str_replace ( '"', '\\"', $value ) : $value;
					$subject = preg_replace ( '/\$\{extractor:xml:' . preg_replace ( '/\//', '\/', preg_quote ( $match ) ) . ';\}/', $replacement, $subject );
				}
			}
		}
		return $subject;
	}

	public function replace_param($subject, $package = 0, $extend = '', $fliter = FALSE) {
		$subject = $this->set_system_param ( $subject, $package, $fliter );
		$subject = $this->set_extractor_param ( $subject, $extend, $fliter );
		$subject = $this->set_function_param ( $subject, $fliter );
		return $subject;
	}

	public function replace_fliter($subject, $package = 0, $extend = '', $fliter = FALSE) {
		$subject = $this->set_extractor_param ( $subject, $extend, $fliter );
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
		$saved_file = Request::get_cookie ( 'cookiefile' );
		if ($saved_file) {
			$file = $saved_file;
		} else {
			$file = $file ? $file : 'local-' . microtime ();
			Cookie::set_cookie ( 'cookiefile', $file, time () + 90 * 24 * 3600 );
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
				curl_setopt ( $ch, CURLOPT_POST, TRUE );
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
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		$response = curl_exec ( $ch );
		$return = $option ? json_encode ( array_merge ( $this->get_header ( $response ), array (
				'code' => curl_getinfo ( $ch, CURLINFO_HTTP_CODE ),
				'time' => curl_getinfo ( $ch, CURLINFO_TOTAL_TIME ) 
		) ) ) : $response;
		curl_close ( $ch );
		return $return;
	}
}