<?php
class Controller_Api_Step_Add extends Controller_Api_Step_Base {

	public function act() {
		// 添加步骤
		if (! $this->check_param ( 'caseid, stepname, steptype, stepvalue, stepsequence' )) {
			V ( 'Json.Base' )->init ( Const_Code::STEP_PARAM_ERROR, '步骤传递参数错误' );
			return;
		}
		
		$case_id = ( int ) Util_Server_Request::get_param ( 'caseid', 'post' );
		
		$result = M ( 'Step' )->insert ();
		
		if (is_null ( $result )) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_STEP_FAIL, '步骤添加失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '步骤添加成功' );
	}
}