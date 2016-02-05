<?php
class Controller_Public_Login extends Controller_Public_Base {

	public function act() {
		// 登录页面
		try {
			M ( 'User' );
		} catch ( Exception $e ) {
			Util_Server_Response::set_header_location ( '/index.php/database' );
			exit ();
		}
		
		$view = V ( 'Html.Public.Login' );
		$view->init ( 'Public.Login' );
	}
}