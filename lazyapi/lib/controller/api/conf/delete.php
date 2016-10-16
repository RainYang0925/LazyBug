<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 删除配置
 */
class Controller_Api_Conf_Delete extends Controller_Api_Conf_Base {

	public function act() {
		if (! $this->check_param ( 'configid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::CONFIG_PARAM_ERROR, '配置传递参数错误' );
			return;
		}
		
		$config_id = ( int ) Request::get_param ( 'configid', 'post' );
		
		LF\M ( 'Conf' )->remove ( $config_id );
		$config = LF\M ( 'Conf' )->get_by_id ( $config_id );
		
		if ($config) {
			LF\V ( 'Json.Base' )->init ( Const_Code::DELETE_CONFIG_FAIL, '配置删除失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '配置删除成功' );
	}
}