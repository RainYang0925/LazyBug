<?php
use Lazybug\Framework\Mod_Model_Relation;

/**
 * Model 模块模型
 */
class Model_Module extends Mod_Model_Relation {

	protected $table_name = 'module';

	protected $fields = array (
			'spaceid' => 'space_id',
			'modulename' => 'name' 
	);

	public function get_by_space($space_id) {
		$where = array (
				'space_id' => $space_id,
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

	public function get_by_name($space_id, $name) {
		$where = array (
				'space_id' => $space_id,
				'name' => $name,
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetch ();
	}

	public function check_name_exists($space_id, $name) {
		$where = array (
				'space_id' => $space_id,
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
				'space_id' => $row ['space_id'],
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

	public function remove_by_space($space_id) {
		$where = array (
				'space_id' => $space_id,
				'status' => 1 
		);
		return $this->where ( $where )->update ( 'status=0' );
	}
}