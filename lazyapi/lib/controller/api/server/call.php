<?php
class Controller_Api_Server_Call extends Controller_Api_Server_Base {

	public function act() {
		// 接口调用
		$call_id = ( int ) Util_Server_Request::get_param ( 'callid', 'post' );
		$package_id = ( int ) Util_Server_Request::get_param ( 'packageid', 'post' );
		$extend = trim ( Util_Server_Request::get_param ( 'extend', 'post' ) );
		$cookie = trim ( Util_Server_Request::get_param ( 'cookie', 'post' ) );
		
		if (! $call_id) {
			return;
		}
		
		$case = M ( 'Case' )->get_by_id ( $call_id );
		
		if (! $case) {
			return;
		}
		
		$item = M ( 'Item' )->get_by_id ( ( int ) $case ['item_id'] );
		
		if (! $item) {
			return;
		}
		
		$case ['url'] = $this->replace_param ( $item ['url'], $package_id, $extend );
		$case ['param'] = $this->replace_param ( $case ['param'], $package_id, $extend );
		$case ['header'] = json_decode ( $this->replace_param ( $case ['header'], $package_id, $extend ), true );
		if (is_null ( $case ['header'] ) || ! is_array ( $case ['header'] )) {
			$case ['header'] = array ();
		}
		$response = $this->set_curl ( $case ['type'], $case ['url'], $case ['param'], $case ['header'], $cookie );
		$this->add_result ( $response );
		
		echo $response;
	}

	private function add_result($content) {
		// 创建测试结果
		$temp = ( int ) Util_Server_Request::get_param ( 'temp', 'post' );
		
		if ($temp) {
			return;
		}
		
		$_POST ['stepid'] = 1;
		$_POST ['steptype'] = '接口调用';
		$_POST ['resultcontent'] = $content;
		M ( 'Result' )->insert ();
	}
}