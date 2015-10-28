<?php
class Controller_Public_Phpinfo extends Controller_Public_Base {

	public function act() {
		phpinfo ();
	}
}