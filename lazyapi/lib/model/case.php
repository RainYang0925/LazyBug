<?php
class Model_Case extends Mod_Model_Relation {

	protected $table_name = 'case';

	protected $fields = array (
			'itemid' => 'item_id',
			'moduleid' => 'module_id',
			'casename' => 'name',
			'caselevel' => 'level',
			'sendtype' => 'stype',
			'contenttype' => 'ctype',
			'requestparam' => 'param',
			'responseheader' => 'header',
			'testexpectation' => 'expectation' 
	);

	public function get_by_item($item_id) {
		$where = array (
				'item_id' => $item_id,
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetchall ();
	}

	public function get_by_level($item_id, $level) {
		$where = array (
				'item_id' => $item_id,
				'level' => array (
						'<=',
						$level 
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

	public function get_by_name($item_id, $name) {
		$where = array (
				'item_id' => $item_id,
				'name' => $name,
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetch ();
	}

	public function get_count() {
		$where = array (
				'status' => 1 
		);
		return $this->select ( 'count(id) as count' )->where ( $where )->fetch ();
	}

	public function get_count_by_module($module_id) {
		if ($module_id) {
			$where = array (
					'module_id' => $module_id,
					'status' => 1 
			);
		} else {
			$where = array (
					'status' => 1 
			);
		}
		return $this->select ( 'count(id) as count' )->where ( $where )->fetch ();
	}

	public function check_name_exists($item_id, $name) {
		$where = array (
				'item_id' => $item_id,
				'name' => $name,
				'status' => 1 
		);
		$row = $this->select ()->where ( $where )->fetch ();
		return $row ? $row ['id'] : 0;
	}

	public function check_name_update($id, $name) {
		$where = array (
				'id' => $id,
				'status' => 1 
		);
		$row = $this->select ()->where ( $where )->fetch ();
		$where = array (
				'id' => array (
						'<>',
						$id 
				),
				'item_id' => $row ['item_id'],
				'name' => $name,
				'status' => 1 
		);
		$row = $this->select ()->where ( $where )->fetch ();
		return $row ? $row ['id'] : 0;
	}

	public function set_level($id, $level) {
		$where = array (
				'id' => $id 
		);
		$update = array (
				'level' => $level 
		);
		return $this->where ( $where )->update ( $update );
	}

	public function switch_module($item_id, $module_id) {
		$where = array (
				'item_id' => $item_id,
				'status' => 1 
		);
		$update = array (
				'module_id' => $module_id 
		);
		return $this->where ( $where )->update ( $update );
	}

	public function reset_module($module_id) {
		$where = array (
				'module_id' => $module_id,
				'status' => 1 
		);
		return $this->where ( $where )->update ( 'module_id=0' );
	}

	public function remove($id) {
		$where = array (
				'id' => $id,
				'status' => 1 
		);
		return $this->where ( $where )->update ( 'status=0' );
	}

	public function remove_by_item($item_id) {
		$where = array (
				'item_id' => $item_id,
				'status' => 1 
		);
		return $this->where ( $where )->update ( 'status=0' );
	}
}