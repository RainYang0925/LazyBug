<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取用例列表
 */
class Controller_Api_Case_List extends Controller_Api_Case_Base {

	public function act() {
		$item_id = ( int ) Request::get_param ( 'itemid', 'post' );
		echo json_encode ( LF\M ( 'Case' )->get_by_item ( $item_id ) );
	}
}