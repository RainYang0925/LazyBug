<?php
class Controller_Api_Public_Login extends Controller_Api_Public_Base {

	public function act() {
		// 登录流程
		if (! $this->check_param ( 'username, password, issave' )) {
			V ( 'Json.Base' )->init ( Const_Code::LOGIN_PARAM_ERROR, '登录传递参数错误' );
			return;
		}
		
		$username = trim ( Util_Server_Request::get_param ( 'username', 'post' ) );
		$password = trim ( Util_Server_Request::get_param ( 'password', 'post' ) );
		$is_save = ( int ) Util_Server_Request::get_param ( 'issave', 'post' );
		
		$time = time ();
		$seckey = lb_read_system ( 'seckey' );
		$user_id = ( int ) M ( 'User' )->check_password ( $username, md5 ( $username . $password ) );
		
		if (! $user_id) {
			V ( 'Json.Base' )->init ( Const_Code::LOGIN_FAIL, '帐号验证失败' );
			return;
		}
		
		$user = M ( 'User' )->get_by_id ( $user_id );
		$expire_time = $is_save ? 86400 * 30 : 0;
		Util_Client_Cookie::set_cookie ( 'userid', $user_id, $expire_time );
		Util_Client_Cookie::set_cookie ( 'username', $user ['name'], $expire_time );
		Util_Client_Cookie::set_cookie ( 'userrole', $user ['role'], $expire_time );
		Util_Client_Cookie::set_cookie ( 'time', $time, $expire_time );
		Util_Client_Cookie::set_cookie ( 'secstr', md5 ( $user_id . '$' . $user ['name'] . '$' . $user ['role'] . '$' . $time . '$' . $seckey ), $expire_time );
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '帐号验证通过' );
	}
}