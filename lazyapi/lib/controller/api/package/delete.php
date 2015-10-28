<?php
class Controller_Api_Package_Delete extends Controller_Api_Package_Base {

	public function act() {
		// 删除配置包
		if (! $this->check_param ( 'packageid' )) {
			V ( 'Json.Base' )->init ( Const_Code::PACKAGE_PARAM_ERROR, '配置包传递参数错误' );
			return;
		}
		
		$package_id = ( int ) Util_Server_Request::get_param ( 'packageid', 'post' );
		
		M ( 'Conf' )->remove_by_package ( $package_id );
		M ( 'Package' )->remove ( $package_id );
		$package = M ( 'Package' )->get_by_id ( $package_id );
		
		if ($package) {
			V ( 'Json.Base' )->init ( Const_Code::DELETE_MODULE_FAIL, '配置包删除失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '配置包删除成功' );
	}
}