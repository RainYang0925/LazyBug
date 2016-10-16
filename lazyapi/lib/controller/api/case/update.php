<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 更新用例
 */
class Controller_Api_Case_Update extends Controller_Api_Case_Base {

	public function act() {
		if (! $this->check_param ( 'caseid, casename, sendtype, contenttype' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::CASE_PARAM_ERROR, '用例传递参数错误' );
			return;
		}
		
		$case_id = ( int ) Request::get_param ( 'caseid', 'post' );
		$case_name = trim ( Request::get_param ( 'casename', 'post' ) );
		
		if (LF\M ( 'Case' )->check_name_update ( $case_id, $case_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_CASE_EXISTS, '用例名称重复' );
			return;
		}
		
		$result = LF\M ( 'Case' )->where ( 'id=' . $case_id )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_CASE_FAIL, '用例更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用例更新成功' );
	}
}