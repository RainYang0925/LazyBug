<?php
class Controller_Api_Server_Remove extends Controller_Api_Server_Base {

	public function act() {
		// 移除作业
		$id = ( int ) Util_Server_Request::get_param ( 'id', 'post' );
		M ( 'Job' )->remove_by_task ( $id );
		echo "done";
	}
}