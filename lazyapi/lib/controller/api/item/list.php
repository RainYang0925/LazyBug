<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取接口列表
 */
class Controller_Api_Item_List extends Controller_Api_Item_Base {

	public function act() {
		$space_id = ( int ) Request::get_param ( 'spaceid', 'post' );
		$module_id = ( int ) Request::get_param ( 'moduleid', 'post' );
		$page = ( int ) Request::get_param ( 'page', 'post' );
		$size = ( int ) Request::get_param ( 'size', 'post' );
		
		if ($page < 1) {
			$page = 1;
		}
		
		if ($size < 1) {
			$size = 10;
		}
		
		if ($module_id) {
			echo json_encode ( LF\M ( 'Item' )->get_by_module ( $module_id, $page, $size ) );
		} else {
			echo json_encode ( LF\M ( 'Item' )->get_by_space ( $space_id, $page, $size ) );
		}
	}
}