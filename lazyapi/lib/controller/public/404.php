<?php
class Controller_Public_404 extends Controller_Public_Base {

	public function act() {
		// 404页面
		$view = V ( 'Html.Public.404' );
		$view->init ( 'Public.404' );
	}
}