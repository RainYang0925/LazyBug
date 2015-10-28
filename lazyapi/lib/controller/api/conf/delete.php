<?php
class Controller_Api_Conf_Delete extends Controller_Api_Conf_Base {

	public function act() {
		// 删除配置
		if (! $this->check_param ( 'configid' )) {
			V ( 'Json.Base' )->init ( Const_Code::CONFIG_PARAM_ERROR, '配置传递参数错误' );
			return;
		}
		
		$config_id = ( int ) Util_Server_Request::get_param ( 'configid', 'post' );
		
		M ( 'Conf' )->remove ( $config_id );
		$config = M ( 'Conf' )->get_by_id ( $config_id );
		
		if ($config) {
			V ( 'Json.Base' )->init ( Const_Code::DELETE_CONFIG_FAIL, '配置删除失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '配置删除成功' );
	}
}