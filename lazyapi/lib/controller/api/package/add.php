<?php
class Controller_Api_Package_Add extends Controller_Api_Package_Base {

	public function act() {
		// 添加配置包
		if (! $this->check_param ( 'packagename' )) {
			V ( 'Json.Base' )->init ( Const_Code::PACKAGE_PARAM_ERROR, '配置包传递参数错误' );
			return;
		}
		
		$package_name = trim ( Util_Server_Request::get_param ( 'packagename', 'post' ) );
		
		if ($package_name === '预设配置' || M ( 'Package' )->check_name_exists ( $package_name )) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_PACKAGE_EXISTS, '配置包名称重复' );
			return;
		}
		
		M ( 'Package' )->insert ();
		$package = M ( 'Package' )->get_by_name ( $package_name );
		$package_id = ( int ) $package ['id'];
		
		if (! $package_id) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_PACKAGE_FAIL, '配置包添加失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $package_id );
	}
} 