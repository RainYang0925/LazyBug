<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;
use Lazybug\Framework\Util_Client_Cookie as Cookie;

/**
 * Controller 登录流程
 */
class Controller_Api_Public_Login extends Controller_Api_Public_Base {

	public function act() {
		if (! $this->check_param ( 'username, password, issave' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::LOGIN_PARAM_ERROR, '登录传递参数错误' );
			return;
		}
		
		$username = trim ( Request::get_param ( 'username', 'post' ) );
		$password = trim ( Request::get_param ( 'password', 'post' ) );
		$is_save = ( int ) Request::get_param ( 'issave', 'post' );
		
		$time = time ();
		$seckey = LF\lb_read_system ( 'seckey' );
		$user_id = ( int ) LF\M ( 'User' )->check_password ( $username, md5 ( $username . $password ) );
		
		if (! $user_id) {
			LF\V ( 'Json.Base' )->init ( Const_Code::LOGIN_FAIL, '帐号验证失败' );
			return;
		}
		
		$user = LF\M ( 'User' )->get_by_id ( $user_id );
		$expire_time = $is_save ? 86400 * 30 : 0;
		Cookie::set_cookie ( 'userid', $user_id, $expire_time );
		Cookie::set_cookie ( 'username', $user ['name'], $expire_time );
		Cookie::set_cookie ( 'userrole', $user ['role'], $expire_time );
		Cookie::set_cookie ( 'time', $time, $expire_time );
		Cookie::set_cookie ( 'secstr', md5 ( $user_id . '$' . $user ['name'] . '$' . $user ['role'] . '$' . $time . '$' . $seckey ), $expire_time );
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '帐号验证通过' );
	}
}