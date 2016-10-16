<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 接口调用
 */
class Controller_Api_Server_Call extends Controller_Api_Server_Base {

	public function act() {
		$call_id = ( int ) Request::get_param ( 'callid', 'post' );
		$package_id = ( int ) Request::get_param ( 'packageid', 'post' );
		$extend = trim ( Request::get_param ( 'extend', 'post' ) );
		$cookie = trim ( Request::get_param ( 'cookie', 'post' ) );
		
		if (! $call_id) {
			return;
		}
		
		$case = LF\M ( 'Case' )->get_by_id ( $call_id );
		
		if (! $case) {
			return;
		}
		
		$item = LF\M ( 'Item' )->get_by_id ( ( int ) $case ['item_id'] );
		
		if (! $item) {
			return;
		}
		
		$extend = preg_replace ( '/\s/', ' ', $extend );
		$extra_info ['url'] = $case ['url'] = $this->replace_param ( $item ['url'], $package_id, $extend );
		$extra_info ['param'] = $case ['param'] = $this->replace_param ( $case ['param'], $package_id, $extend, TRUE );
		$extra_info ['header'] = $case ['header'] = $this->replace_param ( $case ['header'], $package_id, $extend, TRUE );
		
		if ($case ['ctype'] === 'application/x-www-form-urlencoded') {
			$case ['param'] = json_decode ( $case ['param'], TRUE );
			if (is_null ( $case ['param'] ) || ! is_array ( $case ['param'] )) {
				$case ['param'] = '';
			} else {
				$param_array = array ();
				foreach ( $case ['param'] as $key => $value ) {
					$value = is_array ( $value ) ? json_encode ( $value ) : $value;
					$param_array [] = urlencode ( $key ) . '=' . urlencode ( $value );
				}
				$case ['param'] = implode ( $param_array, '&' );
			}
		} else if ($case ['ctype'] === 'multipart/form-data') {
			$case ['param'] = json_decode ( $case ['param'], TRUE );
			if (is_null ( $case ['param'] ) || ! is_array ( $case ['param'] )) {
				$case ['param'] = array ();
			}
		}
		
		$case ['header'] = json_decode ( $case ['header'], TRUE );
		if (is_null ( $case ['header'] ) || ! is_array ( $case ['header'] )) {
			$case ['header'] = array ();
		}
		$case ['header'] ['Content-Type'] = $case ['ctype'];
		$header_array = array ();
		foreach ( $case ['header'] as $key => $value ) {
			$header_array [] = $key . ':' . $value;
		}
		$case ['header'] = $header_array;
		
		$response = $this->set_curl ( $case ['stype'], $case ['url'], $case ['param'], $case ['header'], $cookie );
		$this->add_result ( $response, $extra_info );
		
		echo $response;
	}

	private function add_result($content, $addition) {
		$temp = ( int ) Request::get_param ( 'temp', 'post' );
		
		if ($temp) {
			return;
		}
		
		$_POST ['stepid'] = 1;
		$_POST ['steptype'] = '接口调用';
		$_POST ['resultcontent'] = $content;
		$_POST ['resultvalue1'] = $addition ['url'];
		$_POST ['resultvalue2'] = $addition ['param'];
		$_POST ['resultvalue3'] = $addition ['header'];
		LF\M ( 'Result' )->insert ();
	}
}