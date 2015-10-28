<?php
class Controller_Api_User_Password extends Controller_Api_User_Base {

	public function act() {
		// 更新用户密码
		if (! $this->check_param ( 'oldpassword, newpassword' )) {
			V ( 'Json.Base' )->init ( Const_Code::USER_PARAM_ERROR, '用户传递参数错误' );
			return;
		}
		
		$old_password = trim ( Util_Server_Request::get_param ( 'oldpassword', 'post' ) );
		$new_password = trim ( Util_Server_Request::get_param ( 'newpassword', 'post' ) );
		$user_id = ( int ) $_COOKIE ['userid'];
		$user_name = $_COOKIE ['username'];
		
		$old_password = md5 ( $user_name . $old_password );
		$new_password = md5 ( $user_name . $new_password );
		$user = M ( 'User' )->get_by_id ( $user_id );
		
		if ($old_password !== $user ['passwd']) {
			V ( 'Json.Base' )->init ( Const_Code::USER_CHECK_ERROR, '用户密码校验失败' );
			return;
		}
		
		$_POST ['userpassword'] = $new_password;
		
		$result = M ( 'User' )->where ( 'id=' . $user_id )->update ();
		
		if (is_null ( $result )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_USER_FAIL, '用户密码更新失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用户密码更新成功' );
	}
}