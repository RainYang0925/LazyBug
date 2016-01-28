<?php
abstract class Controller_Base extends Lb_Controller {

	public function check_page_auth() {
		// 页面授权检查
		if (! $this->check_auth ()) {
			Util_Server_Response::set_header_location ( '/index.php/auth' );
			exit ();
		}
	}

	public function check_api_auth() {
		// 接口授权检查
		if (! $this->check_auth ()) {
			V ( 'Json.Base' )->init ( Const_Code::AUTH, '授权限制' );
			exit ();
		}
	}

	private function check_auth() {
		// 访问授权检查
		if ($_COOKIE ['userrole'] === 'admin') {
			return TRUE;
		}
		
		$controller = LB::get_instance ()->get_controller ();
		$config = lb_read_config ( 'auth', $_COOKIE ['userrole'] );
		
		if (! $config || ! in_array ( $controller, $config )) {
			return FALSE;
		}
		
		return TRUE;
	}
}