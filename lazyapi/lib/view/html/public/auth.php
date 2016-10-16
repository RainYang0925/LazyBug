<?php
/**
 * View 授权检查页面视图
 */
class View_Html_Public_Auth extends View_Html_Public_Base {

	protected $title = '授权限制';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Public.Auth' );
		$this->add_script ( 'Js.Public.Auth' );
	}
}