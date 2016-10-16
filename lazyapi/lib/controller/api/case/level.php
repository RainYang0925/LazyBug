<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 设置用例等级
 */
class Controller_Api_Case_Level extends Controller_Api_Case_Base {

	public function act() {
		if (! $this->check_param ( 'caseid, caselevel' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::CASE_PARAM_ERROR, '用例传递参数错误' );
			return;
		}
		
		$case_id = ( int ) Request::get_param ( 'caseid', 'post' );
		$case_level = ( int ) Request::get_param ( 'caselevel', 'post' );
		
		if ($case_level > 4 || $case_level < 1) {
			$case_level = 3;
		}
		
		$result = LF\M ( 'Case' )->set_level ( $case_id, $case_level );
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_CASE_FAIL, '用例等级更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用例等级更新成功' );
	}
}