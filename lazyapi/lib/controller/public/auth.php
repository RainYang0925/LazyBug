<?php
class Controller_Public_Auth extends Controller_Public_Base {

	public function act() {
		// 非授权页面
		$view = V ( 'Html.Public.Auth' );
		$view->init ( 'Public.Auth' );
	}
}