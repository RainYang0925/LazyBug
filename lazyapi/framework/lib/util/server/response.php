<?php
// +------------------------------------------------------------
// | Response 用户响应
// +------------------------------------------------------------
// | Author : yuanhang.chen@gmail.com
// +------------------------------------------------------------
class Util_Server_Response {

	/**
	 * 设置请求头
	 *
	 * @access public
	 * @param string $key 报头字符串
	 * @param string $value 报头字符串
	 * @param bool $replace 是否替换
	 * @param int $code 响应码
	 */
	public static function set_header($key, $value, $replace = TRUE, $code = NULL) {
		header ( $key . ':' . $value, $replace ? TRUE : FALSE, $code );
	}

	/**
	 * 设置状态请求头
	 *
	 * @access public
	 * @param string $status 状态值
	 */
	public static function set_header_status($status) {
		self::set_header ( 'Status', $status );
	}

	/**
	 * 设置定向请求头
	 *
	 * @access public
	 * @param string $url 定向地址
	 * @param int $code 定向类型
	 */
	public static function set_header_location($url, $code = 302) {
		self::set_header ( 'Location', $url, TRUE, $code === 301 ? 301 : 302 );
	}
}
?>