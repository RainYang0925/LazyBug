<?php
class Controller_Api_Job_Delete extends Controller_Api_Job_Base {

	public function act() {
		// 删除作业
		if (! $this->check_param ( 'taskid' )) {
			V ( 'Json.Base' )->init ( Const_Code::JOB_PARAM_ERROR, '作业传递参数错误' );
			return;
		}
		
		$task_id = ( int ) Util_Server_Request::get_param ( 'taskid', 'post' );
		
		M ( 'Job' )->remove_by_task ( $task_id );
		$job = M ( 'Job' )->get_by_task ( $task_id );
		
		if ($job) {
			V ( 'Json.Base' )->init ( Const_Code::DELETE_JOB_FAIL, '作业删除失败' );
			return;
		}
		
		V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '作业删除成功' );
	}
}