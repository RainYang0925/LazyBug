<?php
abstract class Intercepter_Base extends Lb_Intercepter {

	protected function check_cookie() {
		$user_id = Util_Server_Request::get_cookie ( 'userid' );
		$user_name = Util_Server_Request::get_cookie ( 'username' );
		$user_role = Util_Server_Request::get_cookie ( 'userrole' );
		$time = Util_Server_Request::get_cookie ( 'time' );
		$secstr = Util_Server_Request::get_cookie ( 'secstr' );
		$seckey = lb_read_system ( 'seckey' );
		return $secstr === md5 ( $user_id . '$' . $user_name . '$' . $user_role . '$' . $time . '$' . $seckey );
	}

	protected function unset_cookie() {
		Util_Client_Cookie::unset_cookie ( 'userid' );
		Util_Client_Cookie::unset_cookie ( 'username' );
		Util_Client_Cookie::unset_cookie ( 'time' );
		Util_Client_Cookie::unset_cookie ( 'secstr' );
	}
}