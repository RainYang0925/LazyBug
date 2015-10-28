<?php
class Controller_Api_Task_Hang extends Controller_Api_Task_Base {

	public function act() {
		// 设置任务挂起
		if (! $this->check_param ( 'taskid, taskhang' )) {
			V ( 'Json.Base' )->init ( Const_Code::TASK_PARAM_ERROR, '任务传递参数错误' );
			return;
		}
		
		$task_id = ( int ) Util_Server_Request::get_param ( 'taskid', 'post' );
		$task_hang = ( int ) Util_Server_Request::get_param ( 'taskhang', 'post' );
		
		$result = M ( 'Task' )->set_hang ( $task_id, $task_hang );
		
		if (is_null ( $result )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_TASK_FAIL, '任务更新失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '任务更新成功' );
	}
}