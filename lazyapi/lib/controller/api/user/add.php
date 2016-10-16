<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 添加用户
 */
class Controller_Api_User_Add extends Controller_Api_User_Base {

	public function act() {
		if (! $this->check_param ( 'username, userrole' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::USER_PARAM_ERROR, '用户传递参数错误' );
			return;
		}
		
		$user_name = trim ( Request::get_param ( 'username', 'post' ) );
		$user_password = trim ( Request::get_param ( 'userpassword', 'post' ) );
		
		if (! preg_match ( '/^\w+$/', $user_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::USER_FORMAT_ERROR, '用户名称格式错误' );
			return;
		}
		
		if (LF\M ( 'User' )->check_name_exists ( $user_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_USER_EXISTS, '用户名称重复' );
			return;
		}
		
		$_POST ['userpassword'] = $user_password ? md5 ( $user_name . $user_password ) : md5 ( $user_name . '888888' );
		LF\M ( 'User' )->insert ();
		$user = LF\M ( 'User' )->get_by_name ( $user_name );
		$user_id = ( int ) $user ['id'];
		
		if (! $user_id) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_USER_FAIL, '用户添加失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $user_id );
	}
} 