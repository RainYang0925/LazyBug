<?php
class Controller_Api_Case_Request extends Controller_Api_Case_Base {

	public function act() {
		// 请求用例执行
		$send_type = trim ( Util_Server_Request::get_param ( 'sendtype', 'post' ) );
		$item_url = trim ( Util_Server_Request::get_param ( 'itemurl', 'post' ) );
		$request_param = trim ( Util_Server_Request::get_param ( 'requestparam', 'post' ) );
		$request_header = trim ( Util_Server_Request::get_param ( 'requestheader', 'post' ) );
		$request_cookie = trim ( Util_Server_Request::get_param ( 'requestcookie', 'post' ) );
		
		$request_header = json_decode ( $request_header, true );
		if (is_null ( $request_header ) || ! is_array ( $request_header )) {
			$request_header = array ();
		}
		
		echo $this->set_curl ( $send_type, $item_url, $request_param, $request_header, $request_cookie, 1 );
	}
}