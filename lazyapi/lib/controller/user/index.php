<?php
class Controller_User_Index extends Controller_User_Base {

	public function act() {
		// 用户首页
		$user_num = M ( 'User' )->get_count ();
		$view = V ( 'Html.User.Index' );
		$view->add_data ( 'page_num', ceil ( ( int ) $user_num ['count'] / 10 ) );
		$view->init ( 'User.Index' );
	}
}