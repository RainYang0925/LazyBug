<?php
class Intercepter_Login extends Intercepter_Base {

	public function interrupt() {
		// 登录检查
		if ($this->check_cookie ()) {
			Util_Server_Response::set_header_location ( '/' );
			exit ();
		} else {
			$this->unset_cookie ();
		}
	}
}