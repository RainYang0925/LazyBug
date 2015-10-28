<?php
class View_Html_Public_Base extends View_Html_Base {

	public function init($html = '') {
		$this->add_data ( 'body', $html );
		$this->load ( 'Public.Public' );
	}
}