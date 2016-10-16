<?php
use Lazybug\Framework as LF;

/**
 * Controller 环境页面
 */
class Controller_Public_Environment extends Controller_Public_Base {

	public function act() {
		$view = LF\V ( 'Html.Public.Environment' );
		$view->init ( 'Public.Environment' );
	}
}