<?php
class Controller_Api_Result_Content extends Controller_Api_Result_Base {

	public function act() {
		// 获取测试详情
		$result_id = ( int ) Util_Server_Request::get_param ( 'resultid', 'post' );
		$result = M ( 'Result' )->get_by_id ( $result_id );
		echo $result ['content'];
	}
}