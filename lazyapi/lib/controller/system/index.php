<?php
class Controller_System_Index extends Controller_System_Base {

	public function act() {
		// 系统首页
		$system_info = M ( 'System' )->select ()->fetch ();
		$view = V ( 'Html.System.Index' );
		$view->add_data ( 'mail_list', $system_info ['mail_list'] );
		$view->add_data ( 'smtp_server', $system_info ['smtp_server'] );
		$view->add_data ( 'smtp_port', $system_info ['smtp_port'] );
		$view->add_data ( 'smtp_user', $system_info ['smtp_user'] );
		$view->add_data ( 'smtp_password', $system_info ['smtp_password'] );
		$view->init ( 'System.Index' );
	}
}