<?php
class Controller_Api_Module_List extends Controller_Api_Module_Base {

	public function act() {
		// 获取模块列表
		$module_list = M ( 'Module' )->get_all ();
		
		foreach ( $module_list as &$module ) {
			$item_num = M ( 'Item' )->get_count_by_module ( ( int ) $module ['id'] );
			$case_num = M ( 'Case' )->get_count_by_module ( ( int ) $module ['id'] );
			$module ['item_num'] = ( int ) $item_num ['count'];
			$module ['case_num'] = ( int ) $case_num ['count'];
		}
		
		echo json_encode ( $module_list );
	}
}