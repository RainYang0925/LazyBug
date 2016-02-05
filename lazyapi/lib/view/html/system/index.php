<?php
class View_Html_System_Index extends View_Html_Base {

	protected $title = '系统设置';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.System.System' );
		$this->add_script ( 'Js.System.System' );
		$this->add_script ( 'Js.System.Function' );
	}
}