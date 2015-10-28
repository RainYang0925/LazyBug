<?php
class Controller_Api_Case_Add extends Controller_Api_Case_Base {

	public function act() {
		// 添加用例
		if (! $this->check_param ( 'itemid, moduleid, casename, sendtype' )) {
			V ( 'Json.Base' )->init ( Const_Code::CASE_PARAM_ERROR, '用例传递参数错误' );
			return;
		}
		
		$item_id = ( int ) Util_Server_Request::get_param ( 'itemid', 'post' );
		$case_name = trim ( Util_Server_Request::get_param ( 'casename', 'post' ) );
		
		if (M ( 'Case' )->check_name_exists ( $item_id, $case_name )) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_CASE_EXISTS, '用例名称重复' );
			return;
		}
		
		M ( 'Case' )->insert ();
		$case = M ( 'Case' )->get_by_name ( $item_id, $case_name );
		$case_id = ( int ) $case ['id'];
		
		if (! $case_id) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_CASE_FAIL, '用例添加失败' );
			return;
		}
		
		$item = M ( 'Item' )->get_by_id ( $item_id );
		$_POST ['caseid'] = $case_id;
		$_POST ['stepname'] = '调用: ' . $item ['name'] . '->' . $case_name;
		$_POST ['steptype'] = '接口调用';
		$_POST ['stepcommand'] = 'self';
		$_POST ['stepvalue'] = $case_id;
		$_POST ['stepsequence'] = 1;
		M ( 'Step' )->insert ();
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $case_id );
	}
}