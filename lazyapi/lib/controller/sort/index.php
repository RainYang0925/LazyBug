<?php
class Controller_Sort_Index extends Controller_Sort_Base {

	public function act() {
		// 序列首页
		$id = ( int ) Util_Server_Request::get_param ( 'id' );
		
		if (! $id) {
			Util_Server_Response::set_header_location ( '/list' );
			exit ();
		}
		
		$case = M ( 'Case' )->get_by_id ( $id );
		
		if (! $case) {
			Util_Server_Response::set_header_location ( '/list' );
			exit ();
		}
		
		$item = M ( 'Item' )->get_by_id ( ( int ) $case ['item_id'] );
		
		if (! $item) {
			Util_Server_Response::set_header_location ( '/list' );
			exit ();
		}
		
		$view = V ( 'Html.Sort.Index' );
		$view->add_data ( 'case_id', $case ['id'] );
		$view->add_data ( 'item_name', $item ['name'] );
		$view->add_data ( 'case_name', $case ['name'] );
		$view->init ( 'Sort.Index' );
	}
}