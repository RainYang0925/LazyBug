<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 删除用户
 */
class Controller_Api_User_Delete extends Controller_Api_User_Base {

	public function act() {
		if (! $this->check_param ( 'userid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::USER_PARAM_ERROR, '用户传递参数错误' );
			return;
		}
		
		$user_id = ( int ) Request::get_param ( 'userid', 'post' );
		
		LF\M ( 'User' )->remove ( $user_id );
		$user = LF\M ( 'User' )->get_by_id ( $user_id );
		
		if (! $user) {
			LF\V ( 'Json.Base' )->init ( Const_Code::DELETE_USER_FAIL, '用户删除失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '用户删除成功' );
	}
}