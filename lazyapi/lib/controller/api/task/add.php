<?php
class Controller_Api_Task_Add extends Controller_Api_Task_Base {

	public function act() {
		// 添加任务
		if (! $this->check_param ( 'taskname, taskpackage, taskmodule, tasklevel, taskruntime' )) {
			V ( 'Json.Base' )->init ( Const_Code::TASK_PARAM_ERROR, '任务传递参数错误' );
			return;
		}
		
		$task_name = trim ( Util_Server_Request::get_param ( 'taskname', 'post' ) );
		
		if (M ( 'Task' )->check_name_exists ( $task_name )) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_TASK_EXISTS, '任务名称重复' );
			return;
		}
		
		M ( 'Task' )->insert ();
		$task = M ( 'Task' )->get_by_name ( $task_name );
		$task_id = ( int ) $task ['id'];
		
		if (! $task_id) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_TASK_FAIL, '任务添加失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $task_id );
	}
} 