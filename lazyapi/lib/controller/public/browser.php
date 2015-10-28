<?php
class Controller_Public_Browser extends Controller_Public_Base {

	public function act() {
		// 非支持浏览器页面
		$view = V ( 'Html.Public.Browser' );
		$view->init ( 'Public.Browser' );
	}
}