<?php
class Controller_Api_Server_Case extends Controller_Api_Server_Base {

	public function act() {
		// 获取任务用例
		$item_id = ( int ) Util_Server_Request::get_param ( 'itemid', 'post' );
		$task_id = ( int ) Util_Server_Request::get_param ( 'taskid', 'post' );
		$level = ( int ) Util_Server_Request::get_param ( 'level', 'post' );
		
		M ( 'Job' )->increase_current ( $task_id );
		$item = M ( 'Item' )->get_by_id ( $item_id );
		
		if (! $item) {
			V ( 'Xml.Base' )->init ( 'case', array () );
			return;
		}
		
		$_POST ['resultname'] = $item ['name'];
		M ( 'Result' )->insert ();
		
		V ( 'Xml.Base' )->init ( 'case', M ( 'Case' )->get_by_level ( $item_id, $level ) );
	}
}