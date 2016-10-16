<?php
use Lazybug\Framework as LF;

/**
 * Controller 空间首页
 */
class Controller_Space_Index extends Controller_Space_Base {

	public function act() {
		$space_list = LF\M ( 'Space' )->get_all ();
		$view = LF\V ( 'Html.Space.Index' );
		$view->add_data ( 'space_list', $space_list );
		$view->init ( 'Space.Index' );
	}
}