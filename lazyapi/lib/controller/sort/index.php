<?php
use Lazybug\Framework as LF;
use Lazybug\Framework\Util_Server_Request as Request;
use Lazybug\Framework\Util_Server_Response as Response;

/**
 * Controller 序列首页
 */
class Controller_Sort_Index extends Controller_Sort_Base {

	public function act() {
		$id = ( int ) Request::get_param ( 'id' );
		
		if (! $id) {
			Response::set_header_location ( '/index.php/list' );
			exit ();
		}
		
		$case = LF\M ( 'Case' )->get_by_id ( $id );
		
		if (! $case) {
			Response::set_header_location ( '/index.php/list' );
			exit ();
		}
		
		$item = LF\M ( 'Item' )->get_by_id ( ( int ) $case ['item_id'] );
		
		if (! $item) {
			Response::set_header_location ( '/index.php/list' );
			exit ();
		}
		
		$view = LF\V ( 'Html.Sort.Index' );
		$view->add_data ( 'case_id', $case ['id'] );
		$view->add_data ( 'space_id', $case ['space_id'] );
		$view->add_data ( 'item_name', $item ['name'] );
		$view->add_data ( 'case_name', $case ['name'] );
		$view->init ( 'Sort.Index' );
	}
}