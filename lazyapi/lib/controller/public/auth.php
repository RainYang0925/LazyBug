<?php
use Lazybug\Framework as LF;

/**
 * Controller 非授权页面
 */
class Controller_Public_Auth extends Controller_Public_Base {

	public function act() {
		$view = LF\V ( 'Html.Public.Auth' );
		$view->init ( 'Public.Auth' );
	}
}