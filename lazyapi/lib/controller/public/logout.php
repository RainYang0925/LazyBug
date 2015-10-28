<?php
class Controller_Public_Logout extends Controller_Public_Base {

	public function act() {
		// 注销页面
		Util_Client_Cookie::unset_cookie ( 'userid' );
		Util_Server_Response::set_header_location ( '/login' );
		exit ();
	}
}