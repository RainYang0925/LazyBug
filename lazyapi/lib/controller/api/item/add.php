<?php
class Controller_Api_Item_Add extends Controller_Api_Item_Base {

	public function act() {
		// 添加接口
		if (! $this->check_param ( 'itemname, itemurl' )) {
			V ( 'Json.Base' )->init ( Const_Code::ITEM_PARAM_ERROR, '接口传递参数错误' );
			return;
		}
		
		$item_name = trim ( Util_Server_Request::get_param ( 'itemname', 'post' ) );
		
		if (M ( 'Item' )->check_name_exists ( $item_name )) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_ITEM_EXISTS, '接口名称重复' );
			return;
		}
		
		M ( 'Item' )->insert ();
		$item = M ( 'Item' )->get_by_name ( $item_name );
		$item_id = ( int ) $item ['id'];
		
		if (! $item_id) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_ITEM_FAIL, '接口添加失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $item_id );
	}
}