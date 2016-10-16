<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 移除作业
 */
class Controller_Api_Server_Remove extends Controller_Api_Server_Base {

	public function act() {
		$id = ( int ) Request::get_param ( 'id', 'post' );
		LF\M ( 'Job' )->remove_by_task ( $id );
		echo "done";
	}
}