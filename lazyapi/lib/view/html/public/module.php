<?php
/**
 * View 模块检查页面视图
 */
class View_Html_Public_Module extends View_Html_Public_Base {

	protected $title = '必备模块未加载';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Public.Module' );
		$this->add_script ( 'Js.Public.Module' );
	}
}