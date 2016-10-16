<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 开始首页
 */
class Controller_Start_Index extends Controller_Start_Base {

	public function act() {
		$id = ( int ) Request::get_param ( 'reload', 'get' );
		$view = LF\V ( 'Html.Start.Index' );
		$view->add_data ( 'reload_id', $id );
		$view->init ( 'Start.Index' );
	}
}