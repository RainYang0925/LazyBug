<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取测试详情
 */
class Controller_Api_Result_Content extends Controller_Api_Result_Base {

	public function act() {
		$result_id = ( int ) Request::get_param ( 'resultid', 'post' );
		$result = LF\M ( 'Result' )->get_by_id ( $result_id );
		echo json_encode ( array (
				'type' => $result ['step_type'],
				'content' => $result ['content'],
				'value1' => $result ['value_1'],
				'value2' => $result ['value_2'],
				'value3' => $result ['value_3'],
				'value4' => $result ['value_4'],
				'value5' => $result ['value_5'] 
		) );
	}
}