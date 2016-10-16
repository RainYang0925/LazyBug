<?php
use Lazybug\Framework as LF;

/**
 * Controller 运行首页
 */
class Controller_Run_Index extends Controller_Run_Base {

	public function act() {
		$task_num = LF\M ( 'Task' )->get_count ();
		$view = LF\V ( 'Html.Run.Index' );
		$view->add_data ( 'page_num', ceil ( ( int ) $task_num ['count'] / 10 ) );
		$view->init ( 'Run.Index' );
	}
}