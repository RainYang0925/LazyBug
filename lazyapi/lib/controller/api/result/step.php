<?php
class Controller_Api_Result_Step extends Controller_Api_Result_Base {

	public function act() {
		// 获取测试步骤
		$history_id = ( int ) Util_Server_Request::get_param ( 'historyid', 'post' );
		$item_id = ( int ) Util_Server_Request::get_param ( 'itemid', 'post' );
		$case_id = ( int ) Util_Server_Request::get_param ( 'caseid', 'post' );
		echo json_encode ( M ( 'Result' )->get_by_case ( $history_id, $item_id, $case_id ) );
	}
}