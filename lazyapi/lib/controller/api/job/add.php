<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 添加作业
 */
class Controller_Api_Job_Add extends Controller_Api_Job_Base {

	public function act() {
		if (! $this->check_param ( 'taskid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::JOB_PARAM_ERROR, '作业传递参数错误' );
			return;
		}
		
		$task_id = ( int ) Request::get_param ( 'taskid', 'post' );
		
		if (LF\M ( 'Job' )->check_task_exists ( $task_id )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_JOB_EXISTS, '作业已在队列' );
			return;
		}
		
		$task = LF\M ( 'Task' )->get_by_id ( $task_id );
		
		if (! $task) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_JOB_FAIL, '作业添加失败' );
			return;
		}
		
		LF\M ( 'Job' )->insert ();
		$job = LF\M ( 'Job' )->get_by_task ( $task_id );
		$job_id = ( int ) $job ['task_id'];
		
		if (! $job_id) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_JOB_FAIL, '作业添加失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $job_id );
	}
}