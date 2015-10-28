<?php
class Controller_Api_Item_Info extends Controller_Api_Item_Base {

	public function act() {
		// 获取接口信息
		$item_id = ( int ) Util_Server_Request::get_param ( 'itemid', 'post' );
		echo json_encode ( M ( 'Item' )->get_by_id ( $item_id ) );
	}
}