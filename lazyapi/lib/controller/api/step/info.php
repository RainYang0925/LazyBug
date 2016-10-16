<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取步骤列表
 */
class Controller_Api_Step_Info extends Controller_Api_Step_Base {

	public function act() {
		$case_id = ( int ) Request::get_param ( 'caseid', 'post' );
		echo json_encode ( LF\M ( 'Step' )->get_by_case ( $case_id ) );
	}
}