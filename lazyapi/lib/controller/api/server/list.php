<?php
use Lazybug\Framework as LF;

/**
 * Controller 作业列表
 */
class Controller_Api_Server_List extends Controller_Api_Server_Base {

	public function act() {
		$task_list = LF\M ( 'Task' )->get_by_date ();
		
		foreach ( $task_list as $task ) {
			if (preg_match ( '/^[0-9]{2}-[0-9]{2}$/', $task ['runtime'] )) {
				$this->add_job ( ( int ) $task ['id'] );
			}
		}
		
		$job = LF\M ( 'Job' )->get_one ();
		
		if (! $job) {
			LF\V ( 'Xml.Base' )->init ( 'job', array () );
			return;
		}
		
		$result = LF\M ( 'Job' )->reset_by_task ( ( int ) $job ['task_id'] );
		
		if (! $result) {
			LF\V ( 'Xml.Base' )->init ( 'job', array () );
			return;
		}
		
		LF\V ( 'Xml.Base' )->init ( 'job', $job );
	}

	private function add_job($task_id) {
		if (LF\M ( 'Job' )->check_task_exists ( $task_id )) {
			return;
		}
		
		$_POST ['taskid'] = $task_id;
		LF\M ( 'Job' )->insert ();
		$job = LF\M ( 'Job' )->get_by_task ( $task_id );
		
		if (! $job) {
			return;
		}
		
		LF\M ( 'Task' )->set_date ( $task_id );
	}
}