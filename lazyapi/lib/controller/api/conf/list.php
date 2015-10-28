<?php
class Controller_Api_Conf_List extends Controller_Api_Conf_Base {

	public function act() {
		// 获取配置列表
		$package_id = ( int ) Util_Server_Request::get_param ( 'packageid', 'post' );
		$type = trim ( Util_Server_Request::get_param ( 'type', 'post' ) );
		$page = ( int ) Util_Server_Request::get_param ( 'page', 'post' );
		$size = ( int ) Util_Server_Request::get_param ( 'size', 'post' );
		
		if ($page < 1) {
			$page = 1;
		}
		
		if ($size < 1) {
			$size = 10;
		}
		
		echo json_encode ( M ( 'Conf' )->get_by_package ( $package_id, $type, $page, $size ) );
	}
}