<?php
class Controller_Start_Index extends Controller_Start_Base {

	public function act() {
		// 开始首页
		$id = ( int ) Util_Server_Request::get_param ( 'reload', 'get' );
		$view = V ( 'Html.Start.Index' );
		$view->add_data ( 'reload_id', $id );
		$view->init ( 'Start.Index' );
	}
}