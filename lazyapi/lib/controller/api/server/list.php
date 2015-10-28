<?php
class Controller_Api_Server_List extends Controller_Api_Server_Base {

	public function act() {
		// 获取作业
		$task_list = M ( 'Task' )->get_by_date ();
		
		foreach ( $task_list as $task ) {
			if (preg_match ( '/^[0-9]{2}-[0-9]{2}$/', $task ['runtime'] )) {
				$this->add_job ( ( int ) $task ['id'] );
			}
		}
		
		$job = M ( 'Job' )->get_one ();
		
		if (! $job) {
			V ( 'Xml.Base' )->init ( 'job', array () );
			return;
		}
		
		$result = M ( 'Job' )->reset_by_task ( ( int ) $job ['task_id'] );
		
		if (! $result) {
			V ( 'Xml.Base' )->init ( 'job', array () );
			return;
		}
		
		V ( 'Xml.Base' )->init ( 'job', $job );
	}

	private function add_job($task_id) {
		// 添加作业
		if (M ( 'Job' )->check_task_exists ( $task_id )) {
			return;
		}
		
		$_POST ['taskid'] = $task_id;
		M ( 'Job' )->insert ();
		$job = M ( 'Job' )->get_by_task ( $task_id );
		
		if (! $job) {
			return;
		}
		
		M ( 'Task' )->set_date ( $task_id );
	}
}