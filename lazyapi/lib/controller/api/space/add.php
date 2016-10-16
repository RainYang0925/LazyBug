<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 添加空间
 */
class Controller_Api_Space_Add extends Controller_Api_Space_Base {

	public function act() {
		if (! $this->check_param ( 'spacename' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::SPACE_PARAM_ERROR, '空间传递参数错误' );
			return;
		}
		
		$space_name = trim ( Request::get_param ( 'spacename', 'post' ) );
		
		if (LF\M ( 'Space' )->check_name_exists ( $space_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_SPACE_EXISTS, '空间名称重复' );
			return;
		}
		
		LF\M ( 'Space' )->insert ();
		$space = LF\M ( 'Space' )->get_by_name ( $space_name );
		$space_id = ( int ) $space ['id'];
		
		if (! $space_id) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_SPACE_FAIL, '空间添加失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $space_id );
	}
} 