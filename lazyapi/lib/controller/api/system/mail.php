<?php
use Lazybug\Framework as LF;

/**
 * Controller 更新配置
 */
class Controller_Api_System_Mail extends Controller_Api_System_Base {

	public function act() {
		if (! $this->check_param ( 'smtpserver, smtpport' )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::SYSTEM_PARAM_ERROR, '系统传递参数错误' );
			return;
		}
		
		$result = LF\M ( 'System' )->update ();
		
		if (is_null ( $result )) {
			LF\V ( 'Json.Base' )->init ( Const_Code::UPDATE_SYSTEM_FAIL, '系统更新失败' );
			return;
		}
		
		LF\V ( 'Json.Base' )->init ( Const_Code::SUCCESS, '系统更新成功' );
	}
}