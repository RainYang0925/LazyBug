<?php
class Controller_Api_Case_Save extends Controller_Api_Case_Base {

	public function act() {
		// 保存用例
		if (! $this->check_param ( 'itemname, casename, itemurl, sendtype' )) {
			V ( 'Json.Base' )->init ( Const_Code::CASE_PARAM_ERROR, '用例传递参数错误' );
			return;
		}
		
		$item_name = trim ( Util_Server_Request::get_param ( 'itemname', 'post' ) );
		$case_name = trim ( Util_Server_Request::get_param ( 'casename', 'post' ) );
		
		$item_id = ( int ) M ( 'Item' )->check_name_exists ( $item_name );
		
		if ($item_id) {
			$this->update_item ( $item_id, $item_name, $case_name );
		} else {
			$this->new_item ( $item_name, $case_name );
		}
	}

	private function update_item($item_id, $item_name, $case_name) {
		// 更新接口
		$result = M ( 'Item' )->where ( 'id=' . $item_id )->update ();
		
		if (is_null ( $result )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_ITEM_FAIL, '接口更新失败' );
			return;
		}
		
		$case_id = ( int ) M ( 'Case' )->check_name_exists ( $item_id, $case_name );
		
		if ($case_id) {
			$this->update_case ( $case_id );
		} else {
			$this->new_case ( $item_id, $item_name, $case_name );
		}
	}

	private function new_item($item_name, $case_name) {
		// 创建接口
		M ( 'Item' )->insert ();
		$item_id = ( int ) M ( 'Item' )->check_name_exists ( $item_name );
		
		if (! $item_id) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_ITEM_FAIL, '接口添加失败' );
			return;
		}
		
		$this->new_case ( $item_id, $item_name, $case_name );
	}

	private function update_case($case_id) {
		// 更新用例
		$result = M ( 'Case' )->where ( 'id=' . $case_id )->update ();
		
		if (is_null ( $result )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_CASE_FAIL, '用例更新失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用例保存成功' );
	}

	private function new_case($item_id, $item_name, $case_name) {
		// 创建用例
		$item = M ( 'Item' )->get_by_id ( $item_id );
		$_POST ['moduleid'] = ( int ) $item ['module_id'];
		$_POST ['itemid'] = $item_id;
		M ( 'Case' )->insert ();
		$case_id = ( int ) M ( 'Case' )->check_name_exists ( $item_id, $case_name );
		
		if (! $case_id) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_CASE_FAIL, '用例添加失败' );
			return;
		}
		
		$_POST ['caseid'] = $case_id;
		$_POST ['stepname'] = '调用: ' . $item_name . '->' . $case_name;
		$_POST ['steptype'] = '接口调用';
		$_POST ['stepcommand'] = 'self';
		$_POST ['stepvalue'] = $case_id;
		$_POST ['stepsequence'] = 1;
		M ( 'Step' )->insert ();
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用例保存成功' );
	}
}