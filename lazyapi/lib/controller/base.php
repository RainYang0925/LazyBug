<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\LB;
use Lazybug\Framework\Lb_Controller;
use Lazybug\Framework\Util_Server_Response as Response;

/**
 * Controller 控制器基类
 */
abstract class Controller_Base extends Lb_Controller {

	public function check_page_auth() {
		if (! $this->check_auth ()) {
			Response::set_header_location ( '/index.php/auth' );
			exit ();
		}
	}

	public function check_api_auth() {
		if (! $this->check_auth ()) {
			LF\V ( 'Json.Base' )->init ( Const_Code::AUTH, '授权限制' );
			exit ();
		}
	}

	private function check_auth() {
		if ($_COOKIE ['userrole'] === 'admin') {
			return TRUE;
		}
		
		$controller = LB::get_instance ()->get_controller ();
		$config = LF\lb_read_config ( 'auth', $_COOKIE ['userrole'] );
		
		if (! $config || ! in_array ( $controller, $config )) {
			return FALSE;
		}
		
		return TRUE;
	}
}