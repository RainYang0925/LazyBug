<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Response as Response;

/**
 * Controller 登录页面
 */
class Controller_Public_Login extends Controller_Public_Base {

	public function act() {
		try {
			$user = LF\M ( 'User' );
		} catch ( Exception $e ) {
			Response::set_header_location ( '/index.php/database' );
			exit ();
		}
		
		if (! function_exists ( 'curl_init' )) {
			Response::set_header_location ( '/index.php/module?name=php-curl' );
			exit ();
		}
		
		$view = LF\V ( 'Html.Public.Login' );
		$view->init ( 'Public.Login' );
	}
}