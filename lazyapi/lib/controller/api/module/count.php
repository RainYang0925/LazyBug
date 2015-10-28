<?php
class Controller_Api_Module_Count extends Controller_Api_Module_Base {

	public function act() {
		// 计算模块接口用例数
		$module_id = ( int ) Util_Server_Request::get_param ( 'moduleid', 'post' );
		
		$item_num = M ( 'Item' )->get_count_by_module ( $module_id );
		$case_num = M ( 'Case' )->get_count_by_module ( $module_id );
		
		echo json_encode ( array (
				'item_num' => $item_num,
				'case_num' => $case_num 
		) );
	}
}