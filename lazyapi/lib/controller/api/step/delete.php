<?php
class Controller_Api_Step_Delete extends Controller_Api_Step_Base {

	public function act() {
		// 删除步骤
		if (! $this->check_param ( 'caseid' )) {
			V ( 'Json.Base' )->init ( Const_Code::STEP_PARAM_ERROR, '步骤传递参数错误' );
			return;
		}
		
		$case_id = ( int ) Util_Server_Request::get_param ( 'caseid', 'post' );
		
		M ( 'Step' )->remove_by_case ( $case_id );
		$step = M ( 'Step' )->get_by_case ( $case_id );
		
		if ($step) {
			V ( 'Json.Base' )->init ( Const_Code::DELETE_STEP_FAIL, '步骤删除失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '步骤删除成功' );
	}
}