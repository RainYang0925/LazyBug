<?php
class Controller_Api_Conf_Add extends Controller_Api_Conf_Base {

	public function act() {
		// 添加配置
		if (! $this->check_param ( 'packageid, configtype, configkeyword' )) {
			V ( 'Json.Base' )->init ( Const_Code::CONFIG_PARAM_ERROR, '配置传递参数错误' );
			return;
		}
		
		$package_id = ( int ) Util_Server_Request::get_param ( 'packageid', 'post' );
		$config_type = trim ( Util_Server_Request::get_param ( 'configtype', 'post' ) );
		$config_keyword = trim ( Util_Server_Request::get_param ( 'configkeyword', 'post' ) );
		
		if (! preg_match ( '/^\w+$/', $config_keyword )) {
			V ( 'Json.Base' )->init ( Const_Code::CONFIG_FORMAT_ERROR, '配置关键字格式错误' );
			return;
		}
		
		if (M ( 'Conf' )->check_keyword_exists ( $package_id, $config_type, $config_keyword )) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_CONFIG_EXISTS, '配置关键字重复' );
			return;
		}
		
		M ( 'Conf' )->insert ();
		$config = M ( 'Conf' )->get_by_keyword ( $package_id, $config_type, $config_keyword );
		$config_id = ( int ) $config ['id'];
		
		if (! $config_id) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_CONFIG_FAIL, '配置添加失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $config_id );
	}
} 