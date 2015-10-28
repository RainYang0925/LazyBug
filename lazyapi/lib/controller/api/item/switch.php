<?php
class Controller_Api_Item_Switch extends Controller_Api_Item_Base {

	public function act() {
		// 切换接口模块
		if (! $this->check_param ( 'itemid, moduleid' )) {
			V ( 'Json.Base' )->init ( Const_Code::ITEM_PARAM_ERROR, '接口传递参数错误' );
			return;
		}
		
		$item_id = ( int ) Util_Server_Request::get_param ( 'itemid', 'post' );
		$module_id = ( int ) Util_Server_Request::get_param ( 'moduleid', 'post' );
		
		$result_item = M ( 'Item' )->switch_module ( $item_id, $module_id );
		$result_case = M ( 'Case' )->switch_module ( $item_id, $module_id );
		
		if (is_null ( $result_item ) || is_null ( $result_case )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_ITEM_FAIL, '接口更新失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '接口更新成功' );
	}
}