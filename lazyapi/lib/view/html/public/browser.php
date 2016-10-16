<?php
/**
 * View 浏览器检查页面视图
 */
class View_Html_Public_Browser extends View_Html_Public_Base {

	protected $title = '浏览器不支持';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Public.Browser' );
	}
}