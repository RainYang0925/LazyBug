<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取任务
 */
class Controller_Api_Server_Task extends Controller_Api_Server_Base {

	public function act() {
		$id = ( int ) Request::get_param ( 'id', 'post' );
		LF\V ( 'Xml.Base' )->init ( 'task', LF\M ( 'Task' )->get_by_id ( $id ) );
	}
}