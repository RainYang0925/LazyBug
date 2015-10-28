<?php
class Controller_Home_Index extends Controller_Home_Base {

	public function act() {
		// 个人首页
		V ( 'Html.Home.Index' )->init ( 'Home.Index' );
	}
}