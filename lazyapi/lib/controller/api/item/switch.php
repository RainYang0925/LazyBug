<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 切换接口模块
 */
class Controller_Api_Item_Switch extends Controller_Api_Item_Base {

	public function act() {
		if (! $this->check_param ( 'itemid, moduleid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ITEM_PARAM_ERROR, '接口传递参数错误' );
			return;
		}
		
		$item_id = ( int ) Request::get_param ( 'itemid', 'post' );
		$module_id = ( int ) Request::get_param ( 'moduleid', 'post' );
		
		$result_item = LF\M ( 'Item' )->switch_module ( $item_id, $module_id );
		$result_case = LF\M ( 'Case' )->switch_module ( $item_id, $module_id );
		
		if (is_null ( $result_item ) || is_null ( $result_case )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_ITEM_FAIL, '接口更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '接口更新成功' );
	}
}