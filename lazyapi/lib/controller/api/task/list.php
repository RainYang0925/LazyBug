<?php
class Controller_Api_Task_List extends Controller_Api_Task_Base {

	public function act() {
		// 获取任务列表
		$page = ( int ) Util_Server_Request::get_param ( 'page', 'post' );
		$size = ( int ) Util_Server_Request::get_param ( 'size', 'post' );
		$history_size = ( int ) Util_Server_Request::get_param ( 'historysize', 'post' );
		
		if ($page < 1) {
			$page = 1;
		}
		
		if ($size < 1) {
			$size = 20;
		}
		
		if ($history_size) {
			$history_size = 3;
		}
		
		$task_list = M ( 'Task' )->get_all ( $page, $size, $history_size );
		
		foreach ( $task_list as &$task ) {
			$package = M ( 'Package' )->get_by_id ( ( int ) $task ['package_id'] );
			$task ['packagename'] = $package ['name'];
			$module = M ( 'Module' )->get_by_id ( ( int ) $task ['module_id'] );
			$task ['modulename'] = $module ['name'];
			$job = M ( 'Job' )->get_by_task ( ( int ) $task ['id'] );
			$task ['running'] = $job ? 1 : 0;
			$task ['total'] = $job ? ( int ) $job ['total'] : 0;
			$task ['current'] = $job ? ( int ) $job ['current'] : 0;
			$task ['history'] = M ( 'History' )->get_by_task ( ( int ) $task ['id'], 1, $history_size );
		}
		
		echo json_encode ( $task_list );
	}
}