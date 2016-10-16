<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 更新配置包
 */
class Controller_Api_Package_Update extends Controller_Api_Package_Base {

	public function act() {
		if (! $this->check_param ( 'packageid, packagename' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::PACKAGE_PARAM_ERROR, '配置包传递参数错误' );
			return;
		}
		
		$package_id = ( int ) Request::get_param ( 'packageid', 'post' );
		$package_name = trim ( Request::get_param ( 'packagename', 'post' ) );
		
		if (LF\M ( 'Package' )->check_name_update ( $package_id, $package_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_PACKAGE_EXISTS, '配置包名称重复' );
			return;
		}
		
		$result = LF\M ( 'Package' )->where ( 'id=' . $package_id )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_PACKAGE_FAIL, '配置包更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '配置包更新成功' );
	}
}