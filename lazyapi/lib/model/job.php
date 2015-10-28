<?php
class Model_Job extends Mod_Model_Relation {

	protected $table_name = 'job';

	protected $fields = array (
			'taskid' => 'task_id',
			'jobtotal' => 'total',
			'jobcurrent' => 'current' 
	);

	public function get_all() {
		return $this->select ()->fetchall ();
	}

	public function get_one() {
		$where = array (
				'status' => 0 
		);
		return $this->select ()->where ( $where )->fetch ();
	}

	public function get_by_task($task_id) {
		$where = array (
				'task_id' => $task_id 
		);
		return $this->select ()->where ( $where )->fetch ();
	}

	public function check_task_exists($task_id) {
		$where = array (
				'task_id' => $task_id 
		);
		$row = $this->select ()->where ( $where )->fetch ();
		return $row ? $row ['task_id'] : '';
	}

	public function set_total($task_id, $total) {
		$where = array (
				'task_id' => $task_id 
		);
		$update = array (
				'total' => $total 
		);
		return $this->where ( $where )->update ( $update );
	}

	public function increase_current($task_id) {
		$where = array (
				'task_id' => $task_id 
		);
		return $this->where ( $where )->update ( 'current=current+1' );
	}

	public function clear_all() {
		$update = array (
				'status' => 0 
		);
		return $this->update ( $update );
	}

	public function reset_by_task($task_id) {
		$where = array (
				'task_id' => $task_id 
		);
		$update = array (
				'status' => 1 
		);
		return $this->where ( $where )->update ( $update );
	}

	public function remove_by_task($task_id) {
		$where = array (
				'task_id' => $task_id 
		);
		return $this->where ( $where )->delete ();
	}
}