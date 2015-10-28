<?php
class Controller_Api_Server_Check extends Controller_Api_Server_Base {

	public function act() {
		// 检查点
		$result = trim ( Util_Server_Request::get_param ( 'result', 'post' ) );
		$command = trim ( Util_Server_Request::get_param ( 'command', 'post' ) );
		$value = trim ( Util_Server_Request::get_param ( 'value', 'post' ) );
		
		$flag_include = $flag_begin = $flag_end = $flag_reg = 0;
		$match = $value;
		
		foreach ( explode ( '|', $command ) as $command ) {
			$command = trim ( strtolower ( $command ) );
			switch ($command) {
				case 'reg' :
					$flag_reg = 1;
					break;
				case 'all' :
					$flag_begin = $flag_end = 1;
					break;
				case 'begin' :
					$flag_begin = 1;
					break;
				case 'end' :
					$flag_end = 1;
					break;
				default :
			}
		}
		
		$match = $flag_reg ? $match : preg_quote ( $match );
		$match = ($flag_begin ? '/^' : '/') . $match;
		$match = $match . ($flag_end ? '$/' : '/');
		$response = @preg_match ( $match, $result ) ? 'PASS' : 'FAIL';
		$this->add_result ( $response );
		
		echo $response;
	}

	private function add_result($content) {
		// 创建测试结果
		$temp = ( int ) Util_Server_Request::get_param ( 'temp', 'post' );
		$history_id = ( int ) Util_Server_Request::get_param ( 'historyid', 'post' );
		
		if ($temp) {
			return;
		}
		
		if ($content == 'FAIL') {
			$_POST ['resultpass'] = 0;
			M ( 'History' )->increase_fail ( $history_id );
		} else {
			M ( 'History' )->increase_pass ( $history_id );
		}
		
		$_POST ['stepid'] = 1;
		$_POST ['steptype'] = '检查点';
		$_POST ['resultcontent'] = $content;
		M ( 'Result' )->insert ();
	}
}