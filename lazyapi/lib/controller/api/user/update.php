<?php
class Controller_Api_User_Update extends Controller_Api_User_Base {

	public function act() {
		// 更新用户
		if (! $this->check_param ( 'userid, username, userrole' )) {
			V ( 'Json.Base' )->init ( Const_Code::USER_PARAM_ERROR, '用户传递参数错误' );
			return;
		}
		
		$user_id = ( int ) Util_Server_Request::get_param ( 'userid', 'post' );
		$user_name = trim ( Util_Server_Request::get_param ( 'username', 'post' ) );
		$user_password = trim ( Util_Server_Request::get_param ( 'userpassword', 'post' ) );
		
		if (! preg_match ( '/^\w+$/', $user_name )) {
			V ( 'Json.Base' )->init ( Const_Code::USER_FORMAT_ERROR, '用户名称格式错误' );
			return;
		}
		
		if (M ( 'User' )->check_name_update ( $user_id, $user_name )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_USER_EXISTS, '用户名称重复' );
			return;
		}
		
		if ($user_password) {
			$_POST ['userpassword'] = md5 ( $user_name . $user_password );
		} else {
			unset ( $_POST ['userpassword'] );
		}
		
		unset ( $_POST ['username'] );
		$result = M ( 'User' )->where ( 'id=' . $user_id )->update ();
		
		if (is_null ( $result )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_USER_FAIL, '用户更新失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用户更新成功' );
	}
}