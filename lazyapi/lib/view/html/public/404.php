<?php
class View_Html_Public_404 extends View_Html_Public_Base {

	protected $title = '页面不存在';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Public.404' );
		$this->add_script ( 'Js.Public.404' );
	}
}