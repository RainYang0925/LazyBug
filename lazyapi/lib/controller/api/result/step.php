<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取测试步骤
 */
class Controller_Api_Result_Step extends Controller_Api_Result_Base {

	public function act() {
		$history_id = ( int ) Request::get_param ( 'historyid', 'post' );
		$item_id = ( int ) Request::get_param ( 'itemid', 'post' );
		$case_id = ( int ) Request::get_param ( 'caseid', 'post' );
		echo json_encode ( LF\M ( 'Result' )->get_by_case ( $history_id, $item_id, $case_id ) );
	}
}