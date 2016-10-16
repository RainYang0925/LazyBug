<?php
use Lazybug\Framework as LF;

/**
 * Controller 非支持浏览器页面
 */
class Controller_Public_Browser extends Controller_Public_Base {

	public function act() {
		$view = LF\V ( 'Html.Public.Browser' );
		$view->init ( 'Public.Browser' );
	}
}