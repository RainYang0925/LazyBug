<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取配置列表
 */
class Controller_Api_Conf_List extends Controller_Api_Conf_Base {

	public function act() {
		$package_id = ( int ) Request::get_param ( 'packageid', 'post' );
		$type = trim ( Request::get_param ( 'type', 'post' ) );
		$page = ( int ) Request::get_param ( 'page', 'post' );
		$size = ( int ) Request::get_param ( 'size', 'post' );
		
		if ($page < 1) {
			$page = 1;
		}
		
		if ($size < 1) {
			$size = 10;
		}
		
		echo json_encode ( LF\M ( 'Conf' )->get_by_package ( $package_id, $type, $page, $size ) );
	}
}