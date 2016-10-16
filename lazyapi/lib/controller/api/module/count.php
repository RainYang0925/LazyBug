<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 计算模块接口用例数
 */
class Controller_Api_Module_Count extends Controller_Api_Module_Base {

	public function act() {
		$space_id = ( int ) Request::get_param ( 'spaceid', 'post' );
		$module_id = ( int ) Request::get_param ( 'moduleid', 'post' );
		
		if ($module_id) {
			$item_num = LF\M ( 'Item' )->get_count_by_module ( $module_id );
			$case_num = LF\M ( 'Case' )->get_count_by_module ( $module_id );
		} else {
			$item_num = LF\M ( 'Item' )->get_count_by_space ( $space_id );
			$case_num = LF\M ( 'Case' )->get_count_by_space ( $space_id );
		}
		
		echo json_encode ( array (
				'item_num' => $item_num,
				'case_num' => $case_num 
		) );
	}
}