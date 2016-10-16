<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取任务步骤
 */
class Controller_Api_Server_Step extends Controller_Api_Server_Base {

	public function act() {
		$case_id = ( int ) Request::get_param ( 'caseid', 'post' );
		
		$case = LF\M ( 'Case' )->get_by_id ( $case_id );
		
		if (! $case) {
			LF\V ( 'Xml.Base' )->init ( 'step', array () );
			return;
		}
		
		$_POST ['resultname'] = $case ['name'];
		LF\M ( 'Result' )->insert ();
		
		LF\V ( 'Xml.Base' )->init ( 'step', LF\M ( 'Step' )->get_by_case ( $case_id ) );
	}
}