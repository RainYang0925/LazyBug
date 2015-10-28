<?php
class Controller_Api_Item_Delete extends Controller_Api_Item_Base {

	public function act() {
		// 删除接口
		if (! $this->check_param ( 'itemid' )) {
			V ( 'Json.Base' )->init ( Const_Code::ITEM_PARAM_ERROR, '接口传递参数错误' );
			return;
		}
		
		$item_id = ( int ) Util_Server_Request::get_param ( 'itemid', 'post' );
		
		M ( 'Case' )->remove_by_item ( $item_id );
		M ( 'Item' )->remove ( $item_id );
		$item = M ( 'Item' )->get_by_id ( $item_id );
		
		if ($item) {
			V ( 'Json.Base' )->init ( Const_Code::DELETE_ITEM_FAIL, '接口删除失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '接口删除成功' );
	}
}