<?php
class Controller_Api_Item_Update extends Controller_Api_Item_Base {

	public function act() {
		// 更新接口
		if (! $this->check_param ( 'itemid, itemname, itemurl' )) {
			V ( 'Json.Base' )->init ( Const_Code::ITEM_PARAM_ERROR, '接口传递参数错误' );
			return;
		}
		
		$item_id = ( int ) Util_Server_Request::get_param ( 'itemid', 'post' );
		$item_name = trim ( Util_Server_Request::get_param ( 'itemname', 'post' ) );
		
		if (M ( 'Item' )->check_name_update ( $item_id, $item_name )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_ITEM_EXISTS, '接口名称重复' );
			return;
		}
		
		$result = M ( 'Item' )->where ( 'id=' . $item_id )->update ();
		
		if (is_null ( $result )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_ITEM_FAIL, '接口更新失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '接口更新成功' );
	}
}