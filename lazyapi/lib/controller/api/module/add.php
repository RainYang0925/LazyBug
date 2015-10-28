<?php
class Controller_Api_Module_Add extends Controller_Api_Module_Base {

	public function act() {
		// 添加模块
		if (! $this->check_param ( 'modulename' )) {
			V ( 'Json.Base' )->init ( Const_Code::MODULE_PARAM_ERROR, '模块传递参数错误' );
			return;
		}
		
		$module_name = trim ( Util_Server_Request::get_param ( 'modulename', 'post' ) );
		
		if (M ( 'Module' )->check_name_exists ( $module_name )) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_MODULE_EXISTS, '模块名称重复' );
			return;
		}
		
		M ( 'Module' )->insert ();
		$module = M ( 'Module' )->get_by_name ( $module_name );
		$module_id = ( int ) $module ['id'];
		
		if (! $module_id) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_MODULE_FAIL, '模块添加失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $module_id );
	}
} 