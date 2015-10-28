<?php
class Controller_Api_Case_Info extends Controller_Api_Case_Base {

	public function act() {
		// 获取用例信息
		$case_id = ( int ) Util_Server_Request::get_param ( 'caseid', 'post' );
		echo json_encode ( M ( 'Case' )->get_by_id ( $case_id ) );
	}
}