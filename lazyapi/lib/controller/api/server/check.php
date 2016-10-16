<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 检查点
 */
class Controller_Api_Server_Check extends Controller_Api_Server_Base {

	public function act() {
		$result = trim ( Request::get_param ( 'result', 'post' ) );
		$command = trim ( Request::get_param ( 'command', 'post' ) );
		$fliter = trim ( Request::get_param ( 'fliter', 'post' ) );
		$value = trim ( Request::get_param ( 'value', 'post' ) );
		
		$result = $fliter ? $this->replace_fliter ( $fliter, 0, $result ) : $result;
		$flag_include = $flag_begin = $flag_end = $flag_reg = $flag_opposite = 0;
		$extra_info ['source'] = $result;
		$extra_info ['target'] = $match = $value;
		
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
				case 'opposite' :
					$flag_opposite = 1;
					break;
				default :
			}
		}
		
		$match = $flag_reg ? $match : preg_quote ( $match );
		$match = ($flag_begin ? '/^' : '/') . $match;
		$match = $match . ($flag_end ? '$/' : '/');
		
		if ($flag_opposite) {
			$response = @preg_match ( $match, $result ) ? 'FAIL' : 'PASS';
		} else {
			$response = @preg_match ( $match, $result ) ? 'PASS' : 'FAIL';
		}
		
		$this->add_result ( $response, $extra_info );
		
		echo $response;
	}

	private function add_result($content, $addition) {
		$temp = ( int ) Request::get_param ( 'temp', 'post' );
		$history_id = ( int ) Request::get_param ( 'historyid', 'post' );
		
		if ($temp) {
			return;
		}
		
		if ($content == 'FAIL') {
			$_POST ['resultpass'] = 0;
			LF\M ( 'History' )->increase_fail ( $history_id );
		} else {
			LF\M ( 'History' )->increase_pass ( $history_id );
		}
		
		$_POST ['stepid'] = 1;
		$_POST ['steptype'] = '检查点';
		$_POST ['resultcontent'] = $content;
		$_POST ['resultvalue1'] = $addition ['source'];
		$_POST ['resultvalue2'] = $addition ['target'];
		LF\M ( 'Result' )->insert ();
	}
}