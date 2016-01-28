<?php
class Controller_Report_Index extends Controller_Report_Base {

	public function act() {
		// 报告首页
		$id = ( int ) Util_Server_Request::get_param ( 'id' );
		
		if (! $id) {
			Util_Server_Response::set_header_location ( '/index.php/run' );
			exit ();
		}
		
		$history = M ( 'History' )->get_by_id ( $id );
		
		if (! $history) {
			Util_Server_Response::set_header_location ( '/index.php/run' );
			exit ();
		}
		
		$task = M ( 'Task' )->get_by_id ( ( int ) $history ['task_id'] );
		
		if (! $task) {
			Util_Server_Response::set_header_location ( '/index.php/run' );
			exit ();
		}
		
		$view = V ( 'Html.Report.Index' );
		$view->add_data ( 'history_id', $id );
		$view->add_data ( 'task_name', $task ['name'] );
		$view->add_data ( 'task_runtime', $history ['runtime'] );
		$view->init ( 'Report.Index' );
	}
}