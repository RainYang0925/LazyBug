<?php
class Controller_Api_Case_Delete extends Controller_Api_Case_Base {

	public function act() {
		// 删除用例
		if (! $this->check_param ( 'caseid' )) {
			V ( 'Json.Base' )->init ( Const_Code::CASE_PARAM_ERROR, '用例传递参数错误' );
			return;
		}
		
		$case_id = ( int ) Util_Server_Request::get_param ( 'caseid', 'post' );
		
		M ( 'Case' )->remove ( $case_id );
		$case = M ( 'Case' )->get_by_id ( $case_id );
		
		if ($case) {
			V ( 'Json.Base' )->init ( Const_Code::DELETE_CASE_FAIL, '用例删除失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用例删除成功' );
	}
}