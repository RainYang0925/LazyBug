<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 设置任务挂起
 */
class Controller_Api_Task_Hang extends Controller_Api_Task_Base {

	public function act() {
		if (! $this->check_param ( 'taskid, taskhang' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::TASK_PARAM_ERROR, '任务传递参数错误' );
			return;
		}
		
		$task_id = ( int ) Request::get_param ( 'taskid', 'post' );
		$task_hang = ( int ) Request::get_param ( 'taskhang', 'post' );
		
		$result = LF\M ( 'Task' )->set_hang ( $task_id, $task_hang );
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_TASK_FAIL, '任务更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '任务更新成功' );
	}
}