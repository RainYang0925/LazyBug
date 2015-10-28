<?php
class Controller_List_Index extends Controller_List_Base {

	public function act() {
		// 浏览首页
		$item_num = M ( 'Item' )->get_count ();
		$case_num = M ( 'Case' )->get_count ();
		$view = V ( 'Html.List.Index' );
		$view->add_data ( 'item_num', ( int ) $item_num ['count'] );
		$view->add_data ( 'case_num', ( int ) $case_num ['count'] );
		$view->add_data ( 'page_num', ceil ( ( int ) $item_num ['count'] / 10 ) );
		$view->init ( 'List.Index' );
	}
}