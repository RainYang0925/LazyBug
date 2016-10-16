<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 更新用户密码
 */
class Controller_Api_User_Password extends Controller_Api_User_Base {

	public function act() {
		if (! $this->check_param ( 'oldpassword, newpassword' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::USER_PARAM_ERROR, '用户传递参数错误' );
			return;
		}
		
		$old_password = trim ( Request::get_param ( 'oldpassword', 'post' ) );
		$new_password = trim ( Request::get_param ( 'newpassword', 'post' ) );
		$user_id = ( int ) $_COOKIE ['userid'];
		$user_name = $_COOKIE ['username'];
		
		$old_password = md5 ( $user_name . $old_password );
		$new_password = md5 ( $user_name . $new_password );
		$user = LF\M ( 'User' )->get_by_id ( $user_id );
		
		if ($old_password !== $user ['passwd']) {
			LF\V ( 'Json.Base' )->init ( Const_Code::USER_CHECK_ERROR, '用户密码校验失败' );
			return;
		}
		
		$_POST ['userpassword'] = $new_password;
		
		$result = LF\M ( 'User' )->where ( 'id=' . $user_id )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_USER_FAIL, '用户密码更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用户密码更新成功' );
	}
}