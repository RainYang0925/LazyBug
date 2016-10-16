<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取用例信息
 */
class Controller_Api_Case_Info extends Controller_Api_Case_Base {

	public function act() {
		$case_id = ( int ) Request::get_param ( 'caseid', 'post' );
		echo json_encode ( LF\M ( 'Case' )->get_by_id ( $case_id ) );
	}
}