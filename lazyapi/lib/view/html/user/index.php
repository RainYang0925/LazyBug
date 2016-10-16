<?php
/**
 * View 用户页面视图
 */
class View_Html_User_Index extends View_Html_Base {

	protected $title = '用户';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.User.User' );
		$this->add_script ( 'Js.User.Function' );
		$this->add_script ( 'Js.User.User' );
		$this->add_script ( 'Js.Public.Page' );
	}
}