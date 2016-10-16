<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 删除接口
 */
class Controller_Api_Item_Delete extends Controller_Api_Item_Base {

	public function act() {
		if (! $this->check_param ( 'itemid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ITEM_PARAM_ERROR, '接口传递参数错误' );
			return;
		}
		
		$item_id = ( int ) Request::get_param ( 'itemid', 'post' );
		
		LF\M ( 'Case' )->remove_by_item ( $item_id );
		LF\M ( 'Item' )->remove ( $item_id );
		$item = LF\M ( 'Item' )->get_by_id ( $item_id );
		
		if ($item) {
			LF\V ( 'Json.Base' )->init ( Const_Code::DELETE_ITEM_FAIL, '接口删除失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '接口删除成功' );
	}
}