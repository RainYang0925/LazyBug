<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 删除模块
 */
class Controller_Api_Module_Delete extends Controller_Api_Module_Base {

	public function act() {
		if (! $this->check_param ( 'moduleid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::MODULE_PARAM_ERROR, '模块传递参数错误' );
			return;
		}
		
		$module_id = ( int ) Request::get_param ( 'moduleid', 'post' );
		
		LF\M ( 'Item' )->reset_module ( $module_id );
		LF\M ( 'Case' )->reset_module ( $module_id );
		LF\M ( 'Module' )->remove ( $module_id );
		$module = LF\M ( 'Module' )->get_by_id ( $module_id );
		
		if ($module) {
			LF\V ( 'Json.Base' )->init ( Const_Code::DELETE_MODULE_FAIL, '模块删除失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '模块删除成功' );
	}
}