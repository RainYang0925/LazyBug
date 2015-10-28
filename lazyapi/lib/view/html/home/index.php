<?php
class View_Html_Home_Index extends View_Html_Base {

	protected $title = '个人资料';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Home.Home' );
		$this->add_script ( 'Js.Home.Home' );
		$this->add_script ( 'Js.Home.Function' );
	}
}