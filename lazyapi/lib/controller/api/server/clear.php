<?php
class Controller_Api_Server_Clear extends Controller_Api_Server_Base {

	public function act() {
		// 清除作业
		M ( 'Job' )->clear_all ();
		echo "done";
	}
}