<?php
class Controller_Api_Demo_Get extends Controller_Api_Base {

	public function act() {
		print_r ( $_GET );
	}
}