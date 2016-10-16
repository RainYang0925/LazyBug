<?php
/**
 * View 序列页面视图
 */
class View_Html_Sort_Index extends View_Html_Base {

	protected $title = '序列';

	public function __construct() {
		parent::__construct ();
		$this->add_style ( 'Css.Sort.Sort' );
		$this->add_script ( 'Js.Sort.Function' );
		$this->add_script ( 'Js.Sort.Reload' );
		$this->add_script ( 'Js.Sort.Sort' );
	}
}