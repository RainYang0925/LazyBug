<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 添加接口
 */
class Controller_Api_Item_Add extends Controller_Api_Item_Base {

	public function act() {
		if (! $this->check_param ( 'moduleid, spaceid, itemname, itemurl' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ITEM_PARAM_ERROR, '接口传递参数错误' );
			return;
		}
		
		$space_id = ( int ) Request::get_param ( 'spaceid', 'post' );
		$item_name = trim ( Request::get_param ( 'itemname', 'post' ) );
		
		if (LF\M ( 'Item' )->check_name_exists ( $space_id, $item_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_ITEM_EXISTS, '接口名称重复' );
			return;
		}
		
		LF\M ( 'Item' )->insert ();
		$item = LF\M ( 'Item' )->get_by_name ( $space_id, $item_name );
		$item_id = ( int ) $item ['id'];
		
		if (! $item_id) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_ITEM_FAIL, '接口添加失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $item_id );
	}
}