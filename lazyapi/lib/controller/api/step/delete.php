<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 删除步骤
 */
class Controller_Api_Step_Delete extends Controller_Api_Step_Base {

	public function act() {
		if (! $this->check_param ( 'caseid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::STEP_PARAM_ERROR, '步骤传递参数错误' );
			return;
		}
		
		$case_id = ( int ) Request::get_param ( 'caseid', 'post' );
		
		LF\M ( 'Step' )->remove_by_case ( $case_id );
		$step = LF\M ( 'Step' )->get_by_case ( $case_id );
		
		if ($step) {
			LF\V ( 'Json.Base' )->init ( Const_Code::DELETE_STEP_FAIL, '步骤删除失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '步骤删除成功' );
	}
}