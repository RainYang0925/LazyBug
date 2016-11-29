<?php
use Lazybug\Framework\Mod_Model_Relation;

/**
 * Model 任务模型
 */
class Model_Task extends Mod_Model_Relation {

	protected $table_name = 'task';

	protected $fields = array (
			'taskname' => 'name',
			'taskpackage' => 'package_id',
			'taskspace' => 'space_id',
			'taskmodule' => 'module_id',
			'tasklevel' => 'level',
			'taskruntime' => 'runtime',
			'taskhang' => 'hang' 
	);

	public function get_all($page, $size, $history_size) {
		$where = array (
				'status' => 1 
		);
		if ($page && $size) {
			$limit = (($page - 1) * $size) . "," . $size;
			return $this->select ()->where ( $where )->limit ( $limit )->fetchall ();
		}
		return $this->select ()->where ( $where )->fetchall ();
	}

	public function get_by_date() {
		$where = array (
				'runtime' => array (
						'<=',
						date ( 'H-i', time () ) 
				),
				'lasttime' => array (
						'<',
						date ( 'Y-m-d', time () ) 
				),
				'hang' => 0,
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

	public function get_count() {
		$where = array (
				'status' => 1 
		);
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

	public function set_hang($id, $hang) {
		$where = array (
				'id' => $id 
		);
		$update = array (
				'hang' => $hang 
		);
		return $this->where ( $where )->update ( $update );
	}

	public function set_date($id) {
		$where = array (
				'id' => $id 
		);
		$update = array (
				'lasttime' => date ( 'Y-m-d', time () ) 
		);
		return $this->where ( $where )->update ( $update );
	}

	public function remove($id) {
		$where = array (
				'id' => $id,
				'status' => 1 
		);
		return $this->where ( $where )->update ( 'status=0' );
	}
}