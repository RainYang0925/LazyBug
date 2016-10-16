<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 添加用例
 */
class Controller_Api_Case_Add extends Controller_Api_Case_Base {

	public function act() {
		if (! $this->check_param ( 'itemid, moduleid, spaceid, casename, sendtype, contenttype' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::CASE_PARAM_ERROR, '用例传递参数错误' );
			return;
		}
		
		$item_id = ( int ) Request::get_param ( 'itemid', 'post' );
		$case_name = trim ( Request::get_param ( 'casename', 'post' ) );
		
		if (LF\M ( 'Case' )->check_name_exists ( $item_id, $case_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_CASE_EXISTS, '用例名称重复' );
			return;
		}
		
		LF\M ( 'Case' )->insert ();
		$case = LF\M ( 'Case' )->get_by_name ( $item_id, $case_name );
		$case_id = ( int ) $case ['id'];
		
		if (! $case_id) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_CASE_FAIL, '用例添加失败' );
			return;
		}
		
		$item = LF\M ( 'Item' )->get_by_id ( $item_id );
		$_POST ['caseid'] = $case_id;
		$_POST ['stepname'] = '调用: ' . $item ['name'] . '->' . $case_name;
		$_POST ['steptype'] = '接口调用';
		$_POST ['stepcommand'] = 'self';
		$_POST ['stepvalue'] = $case_id;
		$_POST ['stepsequence'] = 1;
		LF\M ( 'Step' )->insert ();
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $case_id );
	}
}