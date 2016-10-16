<?php
/**
 * View 浏览页面视图
 */
class View_Html_List_Index extends View_Html_Base {

	protected $title = '浏览';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.List.List' );
		$this->add_script ( 'Js.List.Function' );
		$this->add_script ( 'Js.List.List' );
		$this->add_script ( 'Js.Public.Page' );
	}
}