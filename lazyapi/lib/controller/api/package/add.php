<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 添加配置包
 */
class Controller_Api_Package_Add extends Controller_Api_Package_Base {

	public function act() {
		if (! $this->check_param ( 'packagename' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::PACKAGE_PARAM_ERROR, '配置包传递参数错误' );
			return;
		}
		
		$package_name = trim ( Request::get_param ( 'packagename', 'post' ) );
		
		if ($package_name === '预设配置' || LF\M ( 'Package' )->check_name_exists ( $package_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_PACKAGE_EXISTS, '配置包名称重复' );
			return;
		}
		
		LF\M ( 'Package' )->insert ();
		$package = LF\M ( 'Package' )->get_by_name ( $package_name );
		$package_id = ( int ) $package ['id'];
		
		if (! $package_id) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_PACKAGE_FAIL, '配置包添加失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $package_id );
	}
} 