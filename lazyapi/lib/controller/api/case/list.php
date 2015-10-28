<?php
class Controller_Api_Case_List extends Controller_Api_Case_Base {

	public function act() {
		// 获取用例列表
		$item_id = ( int ) Util_Server_Request::get_param ( 'itemid', 'post' );
		echo json_encode ( M ( 'Case' )->get_by_item ( $item_id ) );
	}
}