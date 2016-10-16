<?php
use Lazybug\Framework as LF;

/**
 * Controller 获取配置包列表
 */
class Controller_Api_Package_List extends Controller_Api_Package_Base {

	public function act() {
		$package_list = LF\M ( 'Package' )->get_all ();
		
		foreach ( $package_list as &$package ) {
			$param_num = LF\M ( 'Conf' )->get_count_by_package ( ( int ) $package ['id'], 'param' );
			$data_num = LF\M ( 'Conf' )->get_count_by_package ( ( int ) $package ['id'], 'data' );
			$package ['config_num'] ['param'] = ( int ) $param_num ['count'];
			$package ['config_num'] ['data'] = ( int ) $data_num ['count'];
		}
		
		echo json_encode ( $package_list );
	}
}