<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取用户列表
 */
class Controller_Api_User_List extends Controller_Api_User_Base {

	public function act() {
		$page = ( int ) Request::get_param ( 'page', 'post' );
		$size = ( int ) Request::get_param ( 'size', 'post' );
		
		if ($page < 1) {
			$page = 1;
		}
		
		if ($size < 1) {
			$size = 20;
		}
		
		echo json_encode ( LF\M ( 'User' )->get_all ( $page, $size ) );
	}
}