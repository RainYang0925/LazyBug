<?php
class Controller_Api_Server_Step extends Controller_Api_Server_Base {

	public function act() {
		// 获取任务步骤
		$case_id = ( int ) Util_Server_Request::get_param ( 'caseid', 'post' );
		
		$case = M ( 'Case' )->get_by_id ( $case_id );
		
		if (! $case) {
			V ( 'Xml.Base' )->init ( 'step', array () );
			return;
		}
		
		$_POST ['resultname'] = $case ['name'];
		M ( 'Result' )->insert ();
		
		V ( 'Xml.Base' )->init ( 'step', M ( 'Step' )->get_by_case ( $case_id ) );
	}
}