<?php
class Controller_Api_Demo_Json extends Controller_Api_Base {

	public function act() {
		echo json_encode ( array (
				'Name' => 'LazyBug',
				'Sex' => 'M',
				'Age' => 18,
				'Address' => 'ShangHai. CHINA.',
				'Friends' => array (
						'Kevin',
						'John',
						'Lily' 
				) 
		) );
	}
}