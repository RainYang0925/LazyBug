<?php
class Intercepter_User extends Intercepter_Base {

	public function interrupt() {
		// 用户合法检查
		if (! $this->check_cookie ()) {
			$this->unset_cookie ();
			Util_Server_Response::set_header_location ( '/login' );
			exit ();
		}
	}
}