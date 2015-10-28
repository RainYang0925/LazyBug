<?php
class Controller_Api_Server_Task extends Controller_Api_Server_Base {

	public function act() {
		// 获取任务
		$id = ( int ) Util_Server_Request::get_param ( 'id', 'post' );
		V ( 'Xml.Base' )->init ( 'task', M ( 'Task' )->get_by_id ( $id ) );
	}
}