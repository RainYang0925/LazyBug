<?php
class Model_Item extends Mod_Model_Relation {

	protected $table_name = 'item';

	protected $fields = array (
			'moduleid' => 'module_id',
			'itemname' => 'name',
			'itemurl' => 'url' 
	);

	public function get_all($page, $size) {
		$where = array (
				'status' => 1 
		);
		if ($page && $size) {
			$limit = (($page - 1) * $size) . "," . $size;
			return $this->select ()->where ( $where )->limit ( $limit )->fetchall ();
		}
		return $this->select ()->where ( $where )->fetchall ();
	}

	public function get_by_module($module_id, $page, $size) {
		$where = array (
				'module_id' => $module_id,
				'status' => 1 
		);
		if ($page && $size) {
			$limit = (($page - 1) * $size) . "," . $size;
			return $this->select ()->where ( $where )->limit ( $limit )->fetchall ();
		}
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

	public function switch_module($id, $module_id) {
		$where = array (
				'id' => $id,
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
}