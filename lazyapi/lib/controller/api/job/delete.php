<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 删除作业
 */
class Controller_Api_Job_Delete extends Controller_Api_Job_Base {

	public function act() {
		if (! $this->check_param ( 'taskid' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::JOB_PARAM_ERROR, '作业传递参数错误' );
			return;
		}
		
		$task_id = ( int ) Request::get_param ( 'taskid', 'post' );
		
		LF\M ( 'Job' )->remove_by_task ( $task_id );
		$job = LF\M ( 'Job' )->get_by_task ( $task_id );
		
		if ($job) {
			LF\V ( 'Json.Base' )->init ( Const_Code::DELETE_JOB_FAIL, '作业删除失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '作业删除成功' );
	}
}