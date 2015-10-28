<?php
class Controller_Api_Task_Update extends Controller_Api_Task_Base {

	public function act() {
		// 更新任务
		if (! $this->check_param ( 'taskid, taskname, taskpackage, taskmodule, tasklevel, taskruntime' )) {
			V ( 'Json.Base' )->init ( Const_Code::TASK_PARAM_ERROR, '任务传递参数错误' );
			return;
		}
		
		$task_id = ( int ) Util_Server_Request::get_param ( 'taskid', 'post' );
		$task_name = trim ( Util_Server_Request::get_param ( 'taskname', 'post' ) );
		
		if (M ( 'Task' )->check_name_update ( $task_id, $task_name )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_TASK_EXISTS, '任务名称重复' );
			return;
		}
		
		$result = M ( 'Task' )->where ( 'id=' . $task_id )->update ();
		
		if (is_null ( $result )) {
			V ( 'Json.Base' )->init ( Const_Code::UPDATE_TASK_FAIL, '任务更新失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '任务更新成功' );
	}
}