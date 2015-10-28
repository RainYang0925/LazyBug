<?php
class Controller_Api_Job_Add extends Controller_Api_Job_Base {

	public function act() {
		// 添加作业
		if (! $this->check_param ( 'taskid' )) {
			V ( 'Json.Base' )->init ( Const_Code::JOB_PARAM_ERROR, '作业传递参数错误' );
			return;
		}
		
		$task_id = ( int ) Util_Server_Request::get_param ( 'taskid', 'post' );
		
		if (M ( 'Job' )->check_task_exists ( $task_id )) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_JOB_EXISTS, '作业已在队列' );
			return;
		}
		
		$task = M ( 'Task' )->get_by_id ( $task_id );
		
		if (! $task) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_JOB_FAIL, '作业添加失败' );
			return;
		}
		
		M ( 'Job' )->insert ();
		$job = M ( 'Job' )->get_by_task ( $task_id );
		$job_id = ( int ) $job ['task_id'];
		
		if (! $job_id) {
			V ( 'Json.Base' )->init ( Const_Code::ADD_JOB_FAIL, '作业添加失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $job_id );
	}
}