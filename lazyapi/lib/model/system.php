<?php
class Model_System extends Mod_Model_Relation {

	protected $table_name = 'system';

	protected $fields = array (
			'smtpserver' => 'smtp_server',
			'smtpport' => 'smtp_port',
			'smtpuser' => 'smtp_user',
			'smtppassword' => 'smtp_password',
			'maillist' => 'mail_list' 
	);
}