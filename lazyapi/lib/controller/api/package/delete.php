<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 删除配置包
 */
class Controller_Api_Package_Delete extends Controller_Api_Package_Base {

	public function act() {
		if (! $this->check_param ( 'packageid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::PACKAGE_PARAM_ERROR, '配置包传递参数错误' );
			return;
		}
		
		$package_id = ( int ) Request::get_param ( 'packageid', 'post' );
		
		LF\M ( 'Conf' )->remove_by_package ( $package_id );
		LF\M ( 'Package' )->remove ( $package_id );
		$package = LF\M ( 'Package' )->get_by_id ( $package_id );
		
		if ($package) {
			LF\V ( 'Json.Base' )->init ( Const_Code::DELETE_MODULE_FAIL, '配置包删除失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '配置包删除成功' );
	}
}