<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;
use Lazybug\Framework\Util_Server_Response as Response;

/**
 * Controller 报告首页
 */
class Controller_Report_Index extends Controller_Report_Base {

	public function act() {
		$id = ( int ) Request::get_param ( 'id' );
		
		if (! $id) {
			Response::set_header_location ( '/index.php/run' );
			exit ();
		}
		
		$history = LF\M ( 'History' )->get_by_id ( $id );
		
		if (! $history) {
			Response::set_header_location ( '/index.php/run' );
			exit ();
		}
		
		$task = LF\M ( 'Task' )->get_by_id ( ( int ) $history ['task_id'] );
		
		if (! $task) {
			Response::set_header_location ( '/index.php/run' );
			exit ();
		}
		
		$view = LF\V ( 'Html.Report.Index' );
		$view->add_data ( 'history_id', $id );
		$view->add_data ( 'task_name', $task ['name'] );
		$view->add_data ( 'task_runtime', $history ['runtime'] );
		$view->init ( 'Report.Index' );
	}
}