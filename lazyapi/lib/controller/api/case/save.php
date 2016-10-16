<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 保存接口
 */
class Controller_Api_Case_Save extends Controller_Api_Case_Base {

	public function act() {
		if (! $this->check_param ( 'spaceid, itemname, casename, itemurl, sendtype, contenttype' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::CASE_PARAM_ERROR, '用例传递参数错误' );
			return;
		}
		
		$space_id = ( int ) Request::get_param ( 'spaceid', 'post' );
		$item_name = trim ( Request::get_param ( 'itemname', 'post' ) );
		$case_name = trim ( Request::get_param ( 'casename', 'post' ) );
		
		$item_id = ( int ) LF\M ( 'Item' )->check_name_exists ( $space_id, $item_name );
		
		if ($item_id) {
			$this->update_item ( $item_id, $item_name, $case_name );
		} else {
			$this->new_item ( $space_id, $item_name, $case_name );
		}
	}

	private function update_item($item_id, $item_name, $case_name) {
		$result = LF\M ( 'Item' )->where ( 'id=' . $item_id )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_ITEM_FAIL, '接口更新失败' );
			return;
		}
		
		$case_id = ( int ) LF\M ( 'Case' )->check_name_exists ( $item_id, $case_name );
		
		if ($case_id) {
			$this->update_case ( $case_id );
		} else {
			$this->new_case ( $item_id, $item_name, $case_name );
		}
	}

	private function new_item($space_id, $item_name, $case_name) {
		LF\M ( 'Item' )->insert ();
		$item_id = ( int ) LF\M ( 'Item' )->check_name_exists ( $space_id, $item_name );
		
		if (! $item_id) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_ITEM_FAIL, '接口添加失败' );
			return;
		}
		
		$this->new_case ( $item_id, $item_name, $case_name );
	}

	private function update_case($case_id) {
		$result = LF\M ( 'Case' )->where ( 'id=' . $case_id )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_CASE_FAIL, '用例更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用例保存成功' );
	}

	private function new_case($item_id, $item_name, $case_name) {
		$item = LF\M ( 'Item' )->get_by_id ( $item_id );
		$_POST ['moduleid'] = ( int ) $item ['module_id'];
		$_POST ['itemid'] = $item_id;
		LF\M ( 'Case' )->insert ();
		$case_id = ( int ) LF\M ( 'Case' )->check_name_exists ( $item_id, $case_name );
		
		if (! $case_id) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_CASE_FAIL, '用例添加失败' );
			return;
		}
		
		$_POST ['caseid'] = $case_id;
		$_POST ['stepname'] = '调用: ' . $item_name . '->' . $case_name;
		$_POST ['steptype'] = '接口调用';
		$_POST ['stepcommand'] = 'self';
		$_POST ['stepvalue'] = $case_id;
		$_POST ['stepsequence'] = 1;
		LF\M ( 'Step' )->insert ();
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用例保存成功' );
	}
}