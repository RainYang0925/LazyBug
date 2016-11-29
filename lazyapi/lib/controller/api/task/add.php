<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 添加任务
 */
class Controller_Api_Task_Add extends Controller_Api_Task_Base {

	public function act() {
		if (! $this->check_param ( 'taskname, taskpackage, taskspace, taskmodule, tasklevel, taskruntime' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::TASK_PARAM_ERROR, '任务传递参数错误' );
			return;
		}
		
		$task_name = trim ( Request::get_param ( 'taskname', 'post' ) );
		
		if (LF\M ( 'Task' )->check_name_exists ( $task_name )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_TASK_EXISTS, '任务名称重复' );
			return;
		}
		
		LF\M ( 'Task' )->insert ();
		$task = LF\M ( 'Task' )->get_by_name ( $task_name );
		$task_id = ( int ) $task ['id'];
		
		if (! $task_id) {
			LF\V ( 'Json.Base' )->init ( Const_Code::ADD_TASK_FAIL, '任务添加失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, $task_id );
	}
} 