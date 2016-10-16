<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 更新任务
 */
class Controller_Api_Task_Update extends Controller_Api_Task_Base {

	public function act() {
		if (! $this->check_param ( 'taskid, taskname, taskpackage, taskspace, tasklevel, taskruntime' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::TASK_PARAM_ERROR, '任务传递参数错误' );
			return;
		}
		
		$task_id = ( int ) Request::get_param ( 'taskid', 'post' );
		$task_name = trim ( Request::get_param ( 'taskname', 'post' ) );
		
		if (LF\M ( 'Task' )->check_name_update ( $task_id, $task_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_TASK_EXISTS, '任务名称重复' );
			return;
		}
		
		$result = LF\M ( 'Task' )->where ( 'id=' . $task_id )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_TASK_FAIL, '任务更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '任务更新成功' );
	}
}