<?php
class Controller_Api_Task_Delete extends Controller_Api_Task_Base {

	public function act() {
		// 删除任务
		if (! $this->check_param ( 'taskid' )) {
			V ( 'Json.Base' )->init ( Const_Code::TASK_PARAM_ERROR, '任务传递参数错误' );
			return;
		}
		
		$task_id = ( int ) Util_Server_Request::get_param ( 'taskid', 'post' );
		
		M ( 'Task' )->remove ( $task_id );
		$task = M ( 'Task' )->get_by_id ( $task_id );
		
		if ($task) {
			V ( 'Json.Base' )->init ( Const_Code::DELETE_TASK_FAIL, '任务删除失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '任务删除成功' );
	}
}