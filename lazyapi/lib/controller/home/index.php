<?php
use Lazybug\Framework as LF;

/**
 * Controller 个人首页
 */
class Controller_Home_Index extends Controller_Home_Base {

	public function act() {
		LF\V ( 'Html.Home.Index' )->init ( 'Home.Index' );
	}
}