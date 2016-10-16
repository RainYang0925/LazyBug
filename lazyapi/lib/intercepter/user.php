<?php
use Lazybug\Framework\Util_Server_Response as Response;

/**
 * Intercepter 用户合法检查
 */
class Intercepter_User extends Intercepter_Base {

	public function interrupt() {
		if (! $this->check_cookie ()) {
			$this->unset_cookie ();
			Response::set_header_location ( '/index.php/login' );
			exit ();
		}
	}
}