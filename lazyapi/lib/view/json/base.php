<?php
class View_Json_Base extends Mod_View_Json {

	public function init($code = '000000', $message = '') {
		$result = array (
				'code' => $code,
				'message' => $message 
		);
		$this->set_data ( $result );
		$this->output ();
	}
}