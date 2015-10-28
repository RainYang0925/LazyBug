<?php
class Controller_Api_Module_Update extends Controller_Api_Module_Base {

	public function act() {
		// 更新模块
		if (! $this->check_param ( 'moduleid, modulename' )) {
			V ( 'Json.Base' )->init ( Const_Code::MODULE_PARAM_ERROR, '模块传递参数错误' );
			return;
		}
		
		$module_id = ( int ) Util_Server_Request::get_param ( 'moduleid', 'post' );
		$module_name = trim ( Util_Server_Request::get_param ( 'modulename', 'post' ) );
		
		if (M ( 'Module' )->check_name_update ( $module_id, $module_name )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_MODULE_EXISTS, '模块名称重复' );
			return;
		}
		
		$result = M ( 'Module' )->where ( 'id=' . $module_id )->update ();
		
		if (is_null ( $result )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_MODULE_FAIL, '模块更新失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '模块更新成功' );
	}
}