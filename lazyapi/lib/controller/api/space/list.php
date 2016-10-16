<?php
use Lazybug\Framework as LF;

/**
 * Controller 获取空间列表
 */
class Controller_Api_Space_List extends Controller_Api_Module_Base {

	public function act() {
		echo json_encode ( LF\M ( 'Space' )->get_all () );
	}
}