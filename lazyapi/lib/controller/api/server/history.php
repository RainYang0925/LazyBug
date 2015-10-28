<?php
class Controller_Api_Server_History extends Controller_Api_Server_Base {

	public function act() {
		// 创建历史
		if (! $this->check_param ( 'taskid, historysymbol' )) {
			return;
		}
		
		$task_id = ( int ) Util_Server_Request::get_param ( 'taskid', 'post' );
		$history_symbol = trim ( Util_Server_Request::get_param ( 'historysymbol', 'post' ) );
		
		$_POST ['historyruntime'] = date ( 'Y-m-d H:i:s', time () );
		M ( 'History' )->insert ();
		$history = M ( 'History' )->get_by_symbol ( $history_symbol );
		
		if (! $history) {
			return;
		}
		
		echo ( int ) $history ['id'];
	}
}