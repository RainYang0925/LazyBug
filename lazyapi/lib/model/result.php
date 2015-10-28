<?php
class Model_Result extends Mod_Model_Relation {

	protected $table_name = 'result';

	protected $fields = array (
			'historyid' => 'history_id',
			'itemid' => 'item_id',
			'caseid' => 'case_id',
			'stepid' => 'step_id',
			'steptype' => 'step_type',
			'resultname' => 'name',
			'resultcontent' => 'content',
			'resultpass' => 'pass' 
	);

	public function get_by_history($history_id) {
		$where = array (
				'history_id' => $history_id,
				'item_id' => array (
						'>',
						0 
				),
				'case_id' => 0,
				'step_id' => 0,
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetchall ();
	}

	public function get_by_item($history_id, $item_id) {
		$where = array (
				'history_id' => $history_id,
				'item_id' => $item_id,
				'case_id' => array (
						'>',
						0 
				),
				'step_id' => 0,
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetchall ();
	}

	public function get_by_case($history_id, $item_id, $case_id) {
		$where = array (
				'history_id' => $history_id,
				'item_id' => $item_id,
				'case_id' => $case_id,
				'step_id' => array (
						'<>',
						0 
				),
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetchall ();
	}

	public function get_by_id($id) {
		$where = array (
				'id' => $id,
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetch ();
	}

	public function check_pass_status($history_id, $item_id, $case_id) {
		$where = array (
				'history_id' => $history_id,
				'item_id' => $item_id,
				'case_id' => $case_id,
				'step_id' => 1,
				'pass' => 0,
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetchall ();
	}
}