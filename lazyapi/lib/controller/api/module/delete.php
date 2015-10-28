<?php
class Controller_Api_Module_Delete extends Controller_Api_Module_Base {

	public function act() {
		// 删除模块
		if (! $this->check_param ( 'moduleid' )) {
			V ( 'Json.Base' )->init ( Const_Code::MODULE_PARAM_ERROR, '模块传递参数错误' );
			return;
		}
		
		$module_id = ( int ) Util_Server_Request::get_param ( 'moduleid', 'post' );
		
		M ( 'Item' )->reset_module ( $module_id );
		M ( 'Case' )->reset_module ( $module_id );
		M ( 'Module' )->remove ( $module_id );
		$module = M ( 'Module' )->get_by_id ( $module_id );
		
		if ($module) {
			V ( 'Json.Base' )->init ( Const_Code::DELETE_MODULE_FAIL, '模块删除失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '模块删除成功' );
	}
}