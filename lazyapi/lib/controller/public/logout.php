<?php
use Lazybug\Framework\Util_Client_Cookie as Cookie;
use Lazybug\Framework\Util_Server_Response as Response;

/**
 * Controller 注销页面
 */
class Controller_Public_Logout extends Controller_Public_Base {

	public function act() {
		Cookie::unset_cookie ( 'userid' );
		Response::set_header_location ( '/index.php/login' );
		exit ();
	}
}