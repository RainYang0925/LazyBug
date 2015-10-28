<?php
class Controller_Api_User_Delete extends Controller_Api_User_Base {

	public function act() {
		// 删除用户
		if (! $this->check_param ( 'userid' )) {
			V ( 'Json.Base' )->init ( Const_Code::USER_PARAM_ERROR, '用户传递参数错误' );
			return;
		}
		
		$user_id = ( int ) Util_Server_Request::get_param ( 'userid', 'post' );
		
		M ( 'User' )->remove ( $user_id );
		$user = M ( 'User' )->get_by_id ( $user_id );
		
		if (! $user) {
			V ( 'Json.Base' )->init ( Const_Code::DELETE_USER_FAIL, '用户删除失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用户删除成功' );
	}
}