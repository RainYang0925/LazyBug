<?php
class View_Html_Start_Index extends View_Html_Base {

	protected $title = '开始';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Start.Start' );
		$this->add_script ( 'Js.Start.Function' );
		$this->add_script ( 'Js.Start.Reload' );
		$this->add_script ( 'Js.Start.Start' );
		$this->add_script ( 'Js.Public.Format' );
	}
}