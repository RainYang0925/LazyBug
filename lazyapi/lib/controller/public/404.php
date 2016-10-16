<?php
use Lazybug\Framework as LF;

/**
 * Controller 404页面
 */
class Controller_Public_404 extends Controller_Public_Base {

	public function act() {
		$view = LF\V ( 'Html.Public.404' );
		$view->init ( 'Public.404' );
	}
}