<?php
class Controller_Api_Step_Info extends Controller_Api_Step_Base {

	public function act() {
		// 获取步骤列表
		$case_id = ( int ) Util_Server_Request::get_param ( 'caseid', 'post' );
		echo json_encode ( M ( 'Step' )->get_by_case ( $case_id ) );
	}
}