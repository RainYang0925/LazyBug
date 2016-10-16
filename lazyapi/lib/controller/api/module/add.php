<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 添加模块
 */
class Controller_Api_Module_Add extends Controller_Api_Module_Base {

	public function act() {
		if (! $this->check_param ( 'spaceid, modulename' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::MODULE_PARAM_ERROR, '模块传递参数错误' );
			return;
		}
		
		$space_id = ( int ) Request::get_param ( 'spaceid', 'post' );
		$module_name = trim ( Request::get_param ( 'modulename', 'post' ) );
		
		if (LF\M ( 'Module' )->check_name_exists ( $space_id, $module_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_MODULE_EXISTS, '模块名称重复' );
			return;
		}
		
		LF\M ( 'Module' )->insert ();
		$module = LF\M ( 'Module' )->get_by_name ( $space_id, $module_name );
		$module_id = ( int ) $module ['id'];
		
		if (! $module_id) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_MODULE_FAIL, '模块添加失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $module_id );
	}
} 