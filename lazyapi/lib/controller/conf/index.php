<?php
use Lazybug\Framework as LF;

/**
 * Controller 设置首页
 */
class Controller_Conf_Index extends Controller_Conf_Base {

	public function act() {
		$param_num = LF\M ( 'Conf' )->get_count_by_package ( 0, 'param' );
		$data_num = LF\M ( 'Conf' )->get_count_by_package ( 0, 'data' );
		$view = LF\V ( 'Html.Conf.Index' );
		$view->add_data ( 'param_num', ( int ) $param_num ['count'] );
		$view->add_data ( 'data_num', ( int ) $data_num ['count'] );
		$view->add_data ( 'page_num', ceil ( ( int ) $param_num ['count'] / 10 ) );
		$view->init ( 'Conf.Index' );
	}
}