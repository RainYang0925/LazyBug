<?php
/**
 * View 运行页面视图
 */
class View_Html_Run_Index extends View_Html_Base {

	protected $title = '运行';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Run.Run' );
		$this->add_script ( 'Js.Run.Function' );
		$this->add_script ( 'Js.Run.Run' );
		$this->add_script ( 'Js.Public.Page' );
	}
}