<?php
class Controller_Api_Server_Notice extends Controller_Api_Server_Base {

	public function act() {
		// 任务通知
		$history_id = ( int ) Util_Server_Request::get_param ( 'id', 'post' );
		$host = trim ( Util_Server_Request::get_param ( 'host', 'post' ) );
		
		$system_info = M ( 'System' )->select ()->fetch ();
		$history_info = M ( 'History' )->get_by_id ( $history_id );
		
		$pass_num = ( int ) $history_info ['pass'];
		$fail_num = ( int ) $history_info ['fail'];
		
		$title = '接口自动化测试报告 (' . date ( 'Y-m-d h:i:s' ) . ')';
		$result = ($fail_num === 0) ? '<span style="color:#629731">PASS</span>' : '<span style="color:#d0636e">FAIL</span>';
		$content = '<p style="font-size:20px;font-family:Microsoft Yahei, SimHei, Arial;font-weight:bold;">任务结果: ' . $result . '</p>';
		$content .= '<p style="font-size:16px;font-family:Microsoft Yahei, SimHei, Arial;">总共执行' . ($pass_num + $fail_num) . '个检查点，';
		$content .= '通过<span style="color:#629731;font-weight:bold;">' . $pass_num . '</span>，';
		$content .= '失败<span style="color:#d0636e;font-weight:bold;">' . $fail_num . '</span></p>';
		$content .= '<p style="font-size:16px;font-family:Microsoft Yahei, SimHei, Arial;font-weight:bold;"><a stype="color:#22aabe;" href="' . $host . '/report?id=' . $history_id . '" target="_blank">查看详细报告 >></a></p>';
		
		foreach ( explode ( ',', $system_info ['mail_list'] ) as $mail ) {
			$mail = trim ( $mail );
			if (! $mail) {
				continue;
			}
			try {
				$smtp = new Extension_Smtp ();
				$smtp->setServer ( $system_info ['smtp_server'], $system_info ['smtp_user'], $system_info ['smtp_password'], $system_info ['smtp_port'], $system_info ['smtp_ssl'] ? true : false );
				$smtp->setFrom ( 'LazyBug' );
				$smtp->setReceiver ( $mail );
				$smtp->setMail ( $title, $content );
				$smtp->sendMail ();
			} catch ( Exception $e ) {
			}
		}
	}
}