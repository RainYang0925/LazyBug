<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取历史信息
 */
class Controller_Api_Result_Info extends Controller_Api_Result_Base {

	public function act() {
		$history_id = ( int ) Request::get_param ( 'historyid', 'post' );
		
		$result_item_list = LF\M ( 'Result' )->get_by_history ( $history_id );
		
		foreach ( $result_item_list as &$result_item ) {
			
			$result_case_list = LF\M ( 'Result' )->get_by_item ( $history_id, ( int ) $result_item ['item_id'] );
			
			foreach ( $result_case_list as &$result_case ) {
				if (LF\M ( 'Result' )->check_pass_status ( $history_id, ( int ) $result_item ['item_id'], ( int ) $result_case ['case_id'] )) {
					$result_item ['pass'] = 0;
					$result_case ['pass'] = 0;
				}
			}
			
			$result_item ['case_list'] = $result_case_list;
		}
		
		echo json_encode ( $result_item_list );
	}
}