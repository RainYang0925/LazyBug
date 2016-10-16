<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 更新空间
 */
class Controller_Api_Space_Update extends Controller_Api_Space_Base {

	public function act() {
		if (! $this->check_param ( 'spaceid, spacename' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::SPACE_PARAM_ERROR, '空间传递参数错误' );
			return;
		}
		
		$space_id = ( int ) Request::get_param ( 'spaceid', 'post' );
		$space_name = trim ( Request::get_param ( 'spacename', 'post' ) );
		
		if (LF\M ( 'Space' )->check_name_update ( $space_id, $space_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_SPACE_EXISTS, '空间名称重复' );
			return;
		}
		
		$result = LF\M ( 'Space' )->where ( 'id=' . $space_id )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_SPACE_FAIL, '空间更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '空间更新成功' );
	}
}