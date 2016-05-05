<?php
class Model_System extends Mod_Model_Relation {

	protected $table_name = 'system';

	protected $fields = array (
			'smtpserver' => 'smtp_server',
			'smtpport' => 'smtp_port',
			'smtpuser' => 'smtp_user',
			'smtppassword' => 'smtp_password',
			'smtpssl' => 'smtp_ssl',
			'smtpdefaultport' => 'smtp_default_port',
			'maillist' => 'mail_list' 
	);
}