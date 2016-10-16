<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 添加步骤
 */
class Controller_Api_Step_Add extends Controller_Api_Step_Base {

	public function act() {
		if (! $this->check_param ( 'caseid, stepname, steptype, stepvalue, stepsequence' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::STEP_PARAM_ERROR, '步骤传递参数错误' );
			return;
		}
		
		$case_id = ( int ) Request::get_param ( 'caseid', 'post' );
		
		$result = LF\M ( 'Step' )->insert ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_STEP_FAIL, '步骤添加失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '步骤添加成功' );
	}
}