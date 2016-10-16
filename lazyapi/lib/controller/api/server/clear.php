<?php
use Lazybug\Framework as LF;

/**
 * Controller 清除作业
 */
class Controller_Api_Server_Clear extends Controller_Api_Server_Base {

	public function act() {
		LF\M ( 'Job' )->clear_all ();
		echo "done";
	}
}