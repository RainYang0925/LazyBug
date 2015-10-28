<?php
abstract class Controller_Sort_Base extends Controller_Base {

	public function __construct() {
		$this->check_page_auth ();
	}
}