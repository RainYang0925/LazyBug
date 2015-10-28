<?php
class Model_History extends Mod_Model_Relation {

	protected $table_name = 'history';

	protected $fields = array (
			'taskid' => 'task_id',
			'historysymbol' => 'symbol',
			'historyruntime' => 'runtime',
			'historypass' => 'pass',
			'historyfail' => 'fail' 
	);

	public function get_by_task($task_id, $page, $size) {
		$where = array (
				'task_id' => $task_id,
				'status' => 1 
		);
		$order = array (
				'id' => 'desc' 
		);
		if ($page && $size) {
			$limit = (($page - 1) * $size) . "," . $size;
			return $this->select ()->where ( $where )->order ( $order )->limit ( $limit )->fetchall ();
		}
		return $this->select ()->where ( $where )->order ( $order )->fetchall ();
	}

	public function get_by_id($id) {
		$where = array (
				'id' => $id,
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetch ();
	}

	public function get_by_symbol($symbol) {
		$where = array (
				'symbol' => $symbol,
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetch ();
	}

	public function increase_pass($id) {
		$where = array (
				'id' => $id 
		);
		return $this->where ( $where )->update ( 'pass=pass+1' );
	}

	public function increase_fail($id) {
		$where = array (
				'id' => $id 
		);
		return $this->where ( $where )->update ( 'fail=fail+1' );
	}

	public function remove($id) {
		$where = array (
				'id' => $id 
		);
		$update = array (
				'status' => 0 
		);
		return $this->where ( $where )->update ( $update );
	}
}