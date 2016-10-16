<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取接口信息
 */
class Controller_Api_Item_Info extends Controller_Api_Item_Base {

	public function act() {
		$item_id = ( int ) Request::get_param ( 'itemid', 'post' );
		echo json_encode ( LF\M ( 'Item' )->get_by_id ( $item_id ) );
	}
}