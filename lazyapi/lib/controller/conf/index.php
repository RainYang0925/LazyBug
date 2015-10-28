<?php
class Controller_Conf_Index extends Controller_Conf_Base {

	public function act() {
		// 设置首页
		$param_num = M ( 'Conf' )->get_count_by_package ( 0, 'param' );
		$data_num = M ( 'Conf' )->get_count_by_package ( 0, 'data' );
		$view = V ( 'Html.Conf.Index' );
		$view->add_data ( 'param_num', ( int ) $param_num ['count'] );
		$view->add_data ( 'data_num', ( int ) $data_num ['count'] );
		$view->add_data ( 'page_num', ceil ( ( int ) $param_num ['count'] / 10 ) );
		$view->init ( 'Conf.Index' );
	}
}