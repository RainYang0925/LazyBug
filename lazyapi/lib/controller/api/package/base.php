<?php
abstract class Controller_Api_Package_Base extends Controller_Api_Base {

	public function __construct() {
		$this->check_api_auth ();
	}
}