<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取任务用例
 */
class Controller_Api_Server_Case extends Controller_Api_Server_Base {

	public function act() {
		$item_id = ( int ) Request::get_param ( 'itemid', 'post' );
		$task_id = ( int ) Request::get_param ( 'taskid', 'post' );
		$level = ( int ) Request::get_param ( 'level', 'post' );
		
		LF\M ( 'Job' )->increase_current ( $task_id );
		$item = LF\M ( 'Item' )->get_by_id ( $item_id );
		
		if (! $item) {
			LF\V ( 'Xml.Base' )->init ( 'case', array () );
			return;
		}
		
		$_POST ['resultname'] = $item ['name'];
		LF\M ( 'Result' )->insert ();
		
		LF\V ( 'Xml.Base' )->init ( 'case', LF\M ( 'Case' )->get_by_level ( $item_id, $level ) );
	}
}