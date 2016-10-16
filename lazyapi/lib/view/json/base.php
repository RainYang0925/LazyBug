<?php
use Lazybug\Framework\Mod_View_Json;

/**
 * View Json视图基类
 */
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