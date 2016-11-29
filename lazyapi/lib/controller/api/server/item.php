<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取任务接口
 */
class Controller_Api_Server_Item extends Controller_Api_Server_Base {

	public function act() {
		$task_id = ( int ) Request::get_param ( 'taskid', 'post' );
		$space_id = ( int ) Request::get_param ( 'spaceid', 'post' );
		$module_id = ( int ) Request::get_param ( 'moduleid', 'post' );
		
		if ($module_id) {
			$item_list = LF\M ( 'Item' )->get_by_module ( $module_id, 0, 0 );
		} else {
			$item_list = LF\M ( 'Item' )->get_by_space ( $space_id, 0, 0 );
		}
		
		LF\M ( 'Job' )->set_total ( $task_id, count ( $item_list ) );
		
		LF\V ( 'Xml.Base' )->init ( 'item', $item_list );
	}
}