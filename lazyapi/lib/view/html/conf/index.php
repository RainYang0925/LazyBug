<?php
class View_Html_Conf_Index extends View_Html_Base {

	protected $title = '设置';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Conf.Conf' );
		$this->add_script ( 'Js.Conf.Function' );
		$this->add_script ( 'Js.Conf.Conf' );
		$this->add_script ( 'Js.Public.Page' );
	}
}