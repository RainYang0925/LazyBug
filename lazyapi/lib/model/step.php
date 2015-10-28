<?php
class Model_Step extends Mod_Model_Relation {

	protected $table_name = 'step';

	protected $fields = array (
			'caseid' => 'case_id',
			'stepname' => 'name',
			'steptype' => 'type',
			'stepcommand' => 'command',
			'stepvalue' => 'value',
			'stepsequence' => 'sequence' 
	);

	public function get_by_case($case_id) {
		$where = array (
				'case_id' => $case_id 
		);
		$order = array (
				'sequence' => 'asc' 
		);
		return $this->where ( $where )->order ( $order )->fetchall ();
	}

	public function remove_by_case($case_id) {
		$where = array (
				'case_id' => $case_id 
		);
		return $this->where ( $where )->delete ();
	}
}