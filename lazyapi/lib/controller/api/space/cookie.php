<?php
use Lazybug\Framework\Util_Server_Request as Request;
use Lazybug\Framework\Util_Client_Cookie as Cookie;

/**
 * Controller 设置记忆
 */
class Controller_Api_Space_Cookie extends Controller_Api_Space_Base {

	public function act() {
		$space_id = ( int ) Request::get_param ( 'spaceid', 'post' );
		Cookie::set_cookie ( 'current_space', $space_id, 60 * 60 * 24 * 30 );
	}
} 