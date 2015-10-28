<?php
class View_Html_Report_Index extends View_Html_Base {

	protected $title = '记录';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Report.Report' );
		$this->add_script ( 'Js.Report.Function' );
		$this->add_script ( 'Js.Report.Reload' );
		$this->add_script ( 'Js.Report.Report' );
	}
}