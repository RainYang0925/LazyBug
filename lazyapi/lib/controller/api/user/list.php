<?php
class Controller_Api_User_List extends Controller_Api_User_Base {

	public function act() {
		// 获取用户列表
		$page = ( int ) Util_Server_Request::get_param ( 'page', 'post' );
		$size = ( int ) Util_Server_Request::get_param ( 'size', 'post' );
		
		if ($page < 1) {
			$page = 1;
		}
		
		if ($size < 1) {
			$size = 20;
		}
		
		echo json_encode ( M ( 'User' )->get_all ( $page, $size ) );
	}
}