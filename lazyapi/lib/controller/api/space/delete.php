<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 删除模块
 */
class Controller_Api_Space_Delete extends Controller_Api_Space_Base {

	public function act() {
		if (! $this->check_param ( 'spaceid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::SPACE_PARAM_ERROR, '空间传递参数错误' );
			return;
		}
		
		$space_id = ( int ) Request::get_param ( 'spaceid', 'post' );
		
		if ($space_id > 0) {
			LF\M ( 'Item' )->remove_by_space ( $space_id );
			LF\M ( 'Case' )->remove_by_space ( $space_id );
			LF\M ( 'Module' )->remove_by_space ( $space_id );
			LF\M ( 'Space' )->remove ( $space_id );
		}
		
		$space = LF\M ( 'Space' )->get_by_id ( $space_id );
		
		if ($space) {
			LF\V ( 'Json.Base' )->init ( Const_Code::DELETE_SPACE_FAIL, '空间删除失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '空间删除成功' );
	}
}