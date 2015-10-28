<?php
class Model_Module extends Mod_Model_Relation {

	protected $table_name = 'module';

	protected $fields = array (
			'modulename' => 'name' 
	);

	public function get_all() {
		$where = array (
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

	public function get_by_name($name) {
		$where = array (
				'name' => $name,
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetch ();
	}

	public function check_name_exists($name) {
		$where = array (
				'name' => $name,
				'status' => 1 
		);
		$row = $this->select ()->where ( $where )->fetch ();
		return $row ? $row ['id'] : 0;
	}

	public function check_name_update($id, $name) {
		$where = array (
				'id' => array (
						'<>',
						$id 
				),
				'name' => $name,
				'status' => 1 
		);
		$row = $this->select ()->where ( $where )->fetch ();
		return $row ? $row ['id'] : 0;
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