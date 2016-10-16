<?php
use Lazybug\Framework as LF;

/**
 * Controller 用户首页
 */
class Controller_User_Index extends Controller_User_Base {

	public function act() {
		$user_num = LF\M ( 'User' )->get_count ();
		$view = LF\V ( 'Html.User.Index' );
		$view->add_data ( 'page_num', ceil ( ( int ) $user_num ['count'] / 10 ) );
		$view->init ( 'User.Index' );
	}
}