<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;

/**
 * Controller 获取模块列表
 */
class Controller_Api_Module_List extends Controller_Api_Module_Base {

	public function act() {
		$space_id = ( int ) Request::get_param ( 'spaceid', 'post' );
		
		$module_list = LF\M ( 'Module' )->get_by_space ( $space_id );
		
		foreach ( $module_list as &$module ) {
			$item_num = LF\M ( 'Item' )->get_count_by_module ( ( int ) $module ['id'] );
			$case_num = LF\M ( 'Case' )->get_count_by_module ( ( int ) $module ['id'] );
			$module ['item_num'] = ( int ) $item_num ['count'];
			$module ['case_num'] = ( int ) $case_num ['count'];
		}
		
		echo json_encode ( $module_list );
	}
}