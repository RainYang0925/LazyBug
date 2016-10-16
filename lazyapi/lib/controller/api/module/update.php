<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 更新模块
 */
class Controller_Api_Module_Update extends Controller_Api_Module_Base {

	public function act() {
		if (! $this->check_param ( 'moduleid, modulename' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::MODULE_PARAM_ERROR, '模块传递参数错误' );
			return;
		}
		
		$module_id = ( int ) Request::get_param ( 'moduleid', 'post' );
		$module_name = trim ( Request::get_param ( 'modulename', 'post' ) );
		
		if (LF\M ( 'Module' )->check_name_update ( $module_id, $module_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_MODULE_EXISTS, '模块名称重复' );
			return;
		}
		
		$result = LF\M ( 'Module' )->where ( 'id=' . $module_id )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_MODULE_FAIL, '模块更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '模块更新成功' );
	}
}