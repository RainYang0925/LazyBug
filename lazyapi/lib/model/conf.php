<?php
class Model_Conf extends Mod_Model_Relation {

	protected $table_name = 'config';

	protected $fields = array (
			'packageid' => 'package_id',
			'configtype' => 'type',
			'configkeyword' => 'keyword',
			'configvalue' => 'value' 
	);

	public function get_by_package($package_id, $type, $page, $size) {
		$where = array (
				'package_id' => $package_id,
				'type' => $type,
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

	public function get_by_keyword($package_id, $type, $keyword) {
		$where = array (
				'package_id' => $package_id,
				'type' => $type,
				'keyword' => $keyword,
				'status' => 1 
		);
		return $this->select ()->where ( $where )->fetch ();
	}

	public function get_count_by_package($package_id, $type) {
		$where = array (
				'package_id' => $package_id,
				'type' => $type,
				'status' => 1 
		);
		return $this->select ( 'count(id) as count' )->where ( $where )->fetch ();
	}

	public function check_keyword_exists($package_id, $type, $keyword) {
		$where = array (
				'package_id' => $package_id,
				'type' => $type,
				'keyword' => $keyword,
				'status' => 1 
		);
		$row = $this->select ()->where ( $where )->fetch ();
		return $row ? $row ['id'] : 0;
	}

	public function check_keyword_update($id, $package_id, $type, $keyword) {
		$where = array (
				'id' => array (
						'<>',
						$id 
				),
				'package_id' => $package_id,
				'type' => $type,
				'keyword' => $keyword,
				'status' => 1 
		);
		$row = $this->select ()->where ( $where )->fetch ();
		return $row ? $row ['id'] : 0;
	}

	public function remove($id) {
		$where = array (
				'id' => $id,
				'status' => 1 
		);
		return $this->where ( $where )->update ( 'status=0' );
	}

	public function remove_by_package($package_id) {
		$where = array (
				'package_id' => $package_id,
				'status' => 1 
		);
		return $this->where ( $where )->update ( 'status=0' );
	}
}