<?php
class Controller_Api_Conf_Update extends Controller_Api_Conf_Base {

	public function act() {
		// 更新配置
		if (! $this->check_param ( 'configid, packageid, configtype, configkeyword' )) {
			V ( 'Json.Base' )->init ( Const_Code::CONFIG_PARAM_ERROR, '配置传递参数错误' );
			return;
		}
		
		$config_id = ( int ) Util_Server_Request::get_param ( 'configid', 'post' );
		$package_id = ( int ) Util_Server_Request::get_param ( 'packageid', 'post' );
		$config_type = trim ( Util_Server_Request::get_param ( 'configtype', 'post' ) );
		$config_keyword = trim ( Util_Server_Request::get_param ( 'configkeyword', 'post' ) );
		
		if (! preg_match ( '/^\w+$/', $config_keyword )) {
			V ( 'Json.Base' )->init ( Const_Code::CONFIG_FORMAT_ERROR, '配置关键字格式错误' );
			return;
		}
		
		if (M ( 'Conf' )->check_keyword_update ( $config_id, $package_id, $config_type, $config_keyword )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_CONFIG_EXISTS, '配置关键字重复' );
			return;
		}
		
		$result = M ( 'Conf' )->where ( 'id=' . $config_id )->update ();
		
		if (is_null ( $result )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_CONFIG_FAIL, '配置更新失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '配置更新成功' );
	}
}