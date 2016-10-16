<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 更新用户
 */
class Controller_Api_User_Update extends Controller_Api_User_Base {

	public function act() {
		if (! $this->check_param ( 'userid, username, userrole' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::USER_PARAM_ERROR, '用户传递参数错误' );
			return;
		}
		
		$user_id = ( int ) Request::get_param ( 'userid', 'post' );
		$user_name = trim ( Request::get_param ( 'username', 'post' ) );
		$user_password = trim ( Request::get_param ( 'userpassword', 'post' ) );
		
		if (! preg_match ( '/^\w+$/', $user_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::USER_FORMAT_ERROR, '用户名称格式错误' );
			return;
		}
		
		if (LF\M ( 'User' )->check_name_update ( $user_id, $user_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_USER_EXISTS, '用户名称重复' );
			return;
		}
		
		if ($user_password) {
			$_POST ['userpassword'] = md5 ( $user_name . $user_password );
		} else {
			unset ( $_POST ['userpassword'] );
		}
		
		unset ( $_POST ['username'] );
		$result = LF\M ( 'User' )->where ( 'id=' . $user_id )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_USER_FAIL, '用户更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用户更新成功' );
	}
}