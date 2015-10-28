<?php
class View_Html_Public_Login extends View_Html_Public_Base {

	protected $title = '用户登录';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Public.Login' );
		$this->add_script ( 'Js.Public.Login' );
	}
}