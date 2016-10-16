<?php
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 请求用例执行
 */
class Controller_Api_Case_Request extends Controller_Api_Case_Base {

	public function act() {
		$send_type = trim ( Request::get_param ( 'sendtype', 'post' ) );
		$content_type = trim ( Request::get_param ( 'contenttype', 'post' ) );
		$item_url = trim ( Request::get_param ( 'itemurl', 'post' ) );
		$request_param = trim ( Request::get_param ( 'requestparam', 'post' ) );
		$request_header = trim ( Request::get_param ( 'requestheader', 'post' ) );
		$request_cookie = trim ( Request::get_param ( 'requestcookie', 'post' ) );
		
		if ($content_type === 'application/x-www-form-urlencoded') {
			$request_param = json_decode ( $request_param, TRUE );
			if (is_null ( $request_param ) || ! is_array ( $request_param )) {
				$request_param = '';
			} else {
				$param_array = array ();
				foreach ( $request_param as $key => $value ) {
					$value = is_array ( $value ) ? json_encode ( $value ) : $value;
					$param_array [] = urlencode ( $key ) . '=' . urlencode ( $value );
				}
				$request_param = implode ( $param_array, '&' );
			}
		} else if ($content_type === 'multipart/form-data') {
			$request_param = json_decode ( $request_param, TRUE );
			if (is_null ( $request_param ) || ! is_array ( $request_param )) {
				$request_param = array ();
			}
		}
		
		$request_header = json_decode ( $request_header, TRUE );
		if (is_null ( $request_header ) || ! is_array ( $request_header )) {
			$request_header = array ();
		}
		$request_header ['Content-Type'] = $content_type;
		$header_array = array ();
		foreach ( $request_header as $key => $value ) {
			$header_array [] = $key . ':' . $value;
		}
		$request_header = $header_array;
		
		echo $this->set_curl ( $send_type, $item_url, $request_param, $request_header, $request_cookie, 1 );
	}
}