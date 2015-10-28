<?php
class Controller_Api_Server_Item extends Controller_Api_Server_Base {

	public function act() {
		// 获取任务接口
		$task_id = ( int ) Util_Server_Request::get_param ( 'taskid', 'post' );
		$module_id = ( int ) Util_Server_Request::get_param ( 'moduleid', 'post' );
		
		if ($module_id) {
			$item_list = M ( 'Item' )->get_by_module ( $module_id, 0, 0 );
		} else {
			$item_list = M ( 'Item' )->get_all ( 0, 0 );
		}
		M ( 'Job' )->set_total ( $task_id, count ( $item_list ) );
		
		V ( 'Xml.Base' )->init ( 'item', $item_list );
	}
}