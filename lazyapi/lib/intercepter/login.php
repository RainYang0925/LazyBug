<?php
use Lazybug\Framework\Util_Server_Response as Response;

/**
 * Intercepter 登录检查
 */
class Intercepter_Login extends Intercepter_Base {

	public function interrupt() {
		if ($this->check_cookie ()) {
			Response::set_header_location ( '/index.php' );
			exit ();
		} else {
			$this->unset_cookie ();
		}
	}
}