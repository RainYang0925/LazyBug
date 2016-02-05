<?php
class Controller_Public_Database extends Controller_Public_Base {

	public function act() {
		// 数据库错误页面
		$view = V ( 'Html.Public.Database' );
		$view->init ( 'Public.Database' );
	}
}