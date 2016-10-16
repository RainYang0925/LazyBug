<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 更新接口
 */
class Controller_Api_Item_Update extends Controller_Api_Item_Base {

	public function act() {
		if (! $this->check_param ( 'itemid, itemname, itemurl' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ITEM_PARAM_ERROR, '接口传递参数错误' );
			return;
		}
		
		$item_id = ( int ) Request::get_param ( 'itemid', 'post' );
		$item_name = trim ( Request::get_param ( 'itemname', 'post' ) );
		
		if (LF\M ( 'Item' )->check_name_update ( $item_id, $item_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_ITEM_EXISTS, '接口名称重复' );
			return;
		}
		
		$result = LF\M ( 'Item' )->where ( 'id=' . $item_id )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_ITEM_FAIL, '接口更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '接口更新成功' );
	}
}