<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取任务列表
 */
class Controller_Api_Task_List extends Controller_Api_Task_Base {

	public function act() {
		$page = ( int ) Request::get_param ( 'page', 'post' );
		$size = ( int ) Request::get_param ( 'size', 'post' );
		$history_size = ( int ) Request::get_param ( 'historysize', 'post' );
		
		if ($page < 1) {
			$page = 1;
		}
		
		if ($size < 1) {
			$size = 20;
		}
		
		if ($history_size) {
			$history_size = 3;
		}
		
		$task_list = LF\M ( 'Task' )->get_all ( $page, $size, $history_size );
		
		foreach ( $task_list as &$task ) {
			$package = LF\M ( 'Package' )->get_by_id ( ( int ) $task ['package_id'] );
			$task ['packagename'] = $package ['name'];
			$space = LF\M ( 'Space' )->get_by_id ( ( int ) $task ['space_id'] );
			$task ['spacename'] = $space ['name'];
			$job = LF\M ( 'Job' )->get_by_task ( ( int ) $task ['id'] );
			$task ['running'] = $job ? 1 : 0;
			$task ['total'] = $job ? ( int ) $job ['total'] : 0;
			$task ['current'] = $job ? ( int ) $job ['current'] : 0;
			$task ['history'] = LF\M ( 'History' )->get_by_task ( ( int ) $task ['id'], 1, $history_size );
		}
		
		echo json_encode ( $task_list );
	}
}