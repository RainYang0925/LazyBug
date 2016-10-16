<?php
use Lazybug\Framework as LF;

/**
 * Controller 数据库错误页面
 */
class Controller_Public_Database extends Controller_Public_Base {

	public function act() {
		$view = LF\V ( 'Html.Public.Database' );
		$view->init ( 'Public.Database' );
	}
}