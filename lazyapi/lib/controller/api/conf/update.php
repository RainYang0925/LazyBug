<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 更新配置
 */
class Controller_Api_Conf_Update extends Controller_Api_Conf_Base {

	public function act() {
		if (! $this->check_param ( 'configid, packageid, configtype, configkeyword' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::CONFIG_PARAM_ERROR, '配置传递参数错误' );
			return;
		}
		
		$config_id = ( int ) Request::get_param ( 'configid', 'post' );
		$package_id = ( int ) Request::get_param ( 'packageid', 'post' );
		$config_type = trim ( Request::get_param ( 'configtype', 'post' ) );
		$config_keyword = trim ( Request::get_param ( 'configkeyword', 'post' ) );
		
		if (! preg_match ( '/^\w+$/', $config_keyword )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::CONFIG_FORMAT_ERROR, '配置关键字格式错误' );
			return;
		}
		
		if (LF\M ( 'Conf' )->check_keyword_update ( $config_id, $package_id, $config_type, $config_keyword )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_CONFIG_EXISTS, '配置关键字重复' );
			return;
		}
		
		$result = LF\M ( 'Conf' )->where ( 'id=' . $config_id )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_CONFIG_FAIL, '配置更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '配置更新成功' );
	}
}