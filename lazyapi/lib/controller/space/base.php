<?php
abstract class Controller_Space_Base extends Controller_Base {

	public function __construct() {
		$this->check_page_auth ();
	}
}