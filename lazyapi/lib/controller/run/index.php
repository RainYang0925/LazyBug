<?php
class Controller_Run_Index extends Controller_Run_Base {

	public function act() {
		// 运行首页
		$task_num = M ( 'Task' )->get_count ();
		$view = V ( 'Html.Run.Index' );
		$view->add_data ( 'page_num', ceil ( ( int ) $task_num ['count'] / 10 ) );
		$view->init ( 'Run.Index' );
	}
}