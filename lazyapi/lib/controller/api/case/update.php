<?php
class Controller_Api_Case_Update extends Controller_Api_Case_Base {

	public function act() {
		// 更新用例
		if (! $this->check_param ( 'caseid, casename, sendtype, contenttype' )) {
			V ( 'Json.Base' )->init ( Const_Code::CASE_PARAM_ERROR, '用例传递参数错误' );
			return;
		}
		
		$case_id = ( int ) Util_Server_Request::get_param ( 'caseid', 'post' );
		$case_name = trim ( Util_Server_Request::get_param ( 'casename', 'post' ) );
		
		if (M ( 'Case' )->check_name_update ( $case_id, $case_name )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_CASE_EXISTS, '用例名称重复' );
			return;
		}
		
		$result = M ( 'Case' )->where ( 'id=' . $case_id )->update ();
		
		if (is_null ( $result )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_CASE_FAIL, '用例更新失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用例更新成功' );
	}
}