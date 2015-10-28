<?php
class Model_User extends Mod_Model_Relation {

	protected $table_name = 'user';

	protected $fields = array (
			'username' => 'name',
			'userpassword' => 'passwd',
			'userrole' => 'role' 
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

	public function check_password($name, $password) {
		$where = array (
				'name' => $name,
				'status' => 1 
		);
		$user_info = $this->select ()->where ( $where )->fetch ();
		if ($user_info && $user_info ['passwd'] === $password) {
			return $user_info ['id'];
		}
		return 0;
	}

	public function remove($id) {
		$where = array (
				'id' => $id,
				'status' => 1 
		);
		return $this->where ( $where )->update ( 'status=0' );
	}
}