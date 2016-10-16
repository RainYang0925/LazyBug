<?php
/**
 * View 序列页面视图
 */
class View_Html_Space_Index extends View_Html_Base {

	protected $title = '空间管理';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Space.Space' );
		$this->add_script ( 'Js.Space.Function' );
		$this->add_script ( 'Js.Space.Space' );
	}
}