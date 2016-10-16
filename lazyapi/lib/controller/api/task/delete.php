<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 删除任务
 */
class Controller_Api_Task_Delete extends Controller_Api_Task_Base {

	public function act() {
		if (! $this->check_param ( 'taskid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::TASK_PARAM_ERROR, '任务传递参数错误' );
			return;
		}
		
		$task_id = ( int ) Request::get_param ( 'taskid', 'post' );
		
		LF\M ( 'Task' )->remove ( $task_id );
		$task = LF\M ( 'Task' )->get_by_id ( $task_id );
		
		if ($task) {
			LF\V ( 'Json.Base' )->init ( Const_Code::DELETE_TASK_FAIL, '任务删除失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '任务删除成功' );
	}
}