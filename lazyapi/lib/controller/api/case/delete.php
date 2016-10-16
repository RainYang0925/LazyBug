<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 删除用例
 */
class Controller_Api_Case_Delete extends Controller_Api_Case_Base {

	public function act() {
		if (! $this->check_param ( 'caseid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::CASE_PARAM_ERROR, '用例传递参数错误' );
			return;
		}
		
		$case_id = ( int ) Request::get_param ( 'caseid', 'post' );
		
		LF\M ( 'Case' )->remove ( $case_id );
		$case = LF\M ( 'Case' )->get_by_id ( $case_id );
		
		if ($case) {
			LF\V ( 'Json.Base' )->init ( Const_Code::DELETE_CASE_FAIL, '用例删除失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用例删除成功' );
	}
}