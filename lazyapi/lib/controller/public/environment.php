<?php
class Controller_Public_Environment extends Controller_Public_Base {

	public function act() {
		// 环境页面
		$view = V ( 'Html.Public.Environment' );
		$view->init ( 'Public.Environment' );
	}
}