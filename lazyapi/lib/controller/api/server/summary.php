<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 创建历史
 */
class Controller_Api_Server_Summary extends Controller_Api_Server_Base {

	public function act() {
		if (! $this->check_param ( 'guid' )) {
			return;
		}
		
		$guid = trim ( Request::get_param ( 'guid', 'post' ) );
		
		LF\V ( 'Xml.Base' )->init ( 'summary', LF\M ( 'History' )->get_by_guid ( $guid ) );
	}
}