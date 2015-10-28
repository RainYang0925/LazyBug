<?php
class Controller_Api_Item_List extends Controller_Api_Item_Base {

	public function act() {
		// 获取接口列表
		$module_id = ( int ) Util_Server_Request::get_param ( 'moduleid', 'post' );
		$page = ( int ) Util_Server_Request::get_param ( 'page', 'post' );
		$size = ( int ) Util_Server_Request::get_param ( 'size', 'post' );
		
		if ($page < 1) {
			$page = 1;
		}
		
		if ($size < 1) {
			$size = 10;
		}
		
		if ($module_id) {
			echo json_encode ( M ( 'Item' )->get_by_module ( $module_id, $page, $size ) );
		} else {
			echo json_encode ( M ( 'Item' )->get_all ( $page, $size ) );
		}
	}
}