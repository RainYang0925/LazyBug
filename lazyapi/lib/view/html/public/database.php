<?php
/**
 * View 数据库检查页面视图
 */
class View_Html_Public_Database extends View_Html_Public_Base {

	protected $title = '数据库连接失败';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Public.Database' );
		$this->add_script ( 'Js.Public.Database' );
	}
}