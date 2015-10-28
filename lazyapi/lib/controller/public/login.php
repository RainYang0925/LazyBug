<?php
class Controller_Public_Login extends Controller_Public_Base {

	public function act() {
		// 登录页面
		$view = V ( 'Html.Public.Login' );
		$view->init ( 'Public.Login' );
	}
}