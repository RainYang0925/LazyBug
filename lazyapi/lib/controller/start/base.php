<?php
abstract class Controller_Start_Base extends Controller_Base {

	public function __construct() {
		$this->check_page_auth ();
	}
}