<?php
use Lazybug\Framework as LF;

/**
 * Controller 模块错误页面
 */
class Controller_Public_Module extends Controller_Public_Base {

	public function act() {
		$view = LF\V ( 'Html.Public.Module' );
		$view->init ( 'Public.Module' );
	}
}