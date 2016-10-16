<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 创建历史
 */
class Controller_Api_Server_History extends Controller_Api_Server_Base {

	public function act() {
		if (! $this->check_param ( 'taskid, guid' )) {
			return;
		}
		
		$task_id = ( int ) Request::get_param ( 'taskid', 'post' );
		$guid = trim ( Request::get_param ( 'guid', 'post' ) );
		
		$_POST ['historyruntime'] = date ( 'Y-m-d H:i:s', time () );
		LF\M ( 'History' )->insert ();
		$history = LF\M ( 'History' )->get_by_guid ( $guid );
		
		if (! $history) {
			return;
		}
		
		echo ( int ) $history ['id'];
	}
}