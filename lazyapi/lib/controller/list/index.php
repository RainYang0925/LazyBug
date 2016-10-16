<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 浏览首页
 */
class Controller_List_Index extends Controller_List_Base {

	public function act() {
		$space_id = ( int ) Request::get_cookie ( 'current_space' );
		
		$space = LF\M ( 'Space' )->get_by_id ( $space_id );
		
		if ($space) {
			$space_name = $space ['name'];
		} else {
			$space_id = 0;
			$space_name = '默认空间';
		}
		
		$item_num = LF\M ( 'Item' )->get_count_by_space ( $space_id );
		$case_num = LF\M ( 'Case' )->get_count_by_space ( $space_id );
		
		$view = LF\V ( 'Html.List.Index' );
		$view->add_data ( 'current_space_id', $space_id );
		$view->add_data ( 'current_space_name', $space_name );
		$view->add_data ( 'item_num', ( int ) $item_num ['count'] );
		$view->add_data ( 'case_num', ( int ) $case_num ['count'] );
		$view->add_data ( 'page_num', ceil ( ( int ) $item_num ['count'] / 10 ) );
		$view->init ( 'List.Index' );
	}
}