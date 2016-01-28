<?php
// +------------------------------------------------------------
// | Convert 格式转换
// +------------------------------------------------------------
// | 在路径格式、类名格式和引用格式之间相互转换
// +------------------------------------------------------------
// | Author : yuanhang.chen@gmail.com
// +------------------------------------------------------------

/**
 * 路径格式转换为类名格式
 *
 * @param string $path 路径格式
 * @return string $class 类名格式
 */
function lb_convert_path_to_class($path) {
	return lb_convert_string_format ( $path, '/', '_' );
}

/**
 * 路径格式转换为引用格式
 *
 * @param string $path 路径格式
 * @return string $quote 引用格式
 */
function lb_convert_path_to_quote($path) {
	return lb_convert_string_format ( $path, '/', '.' );
}

/**
 * 类名格式转换为路径格式
 *
 * @param string $class 类名格式
 * @return string $path 路径格式
 */
function lb_convert_class_to_path($class) {
	return lb_convert_string_format ( $class, '_', '/' );
}

/**
 * 类名格式转换为引用格式
 *
 * @param string $class 类名格式
 * @return string $quote 引用格式
 */
function lb_convert_class_to_quote($class) {
	return lb_convert_string_format ( $class, '_', '.' );
}

/**
 * 引用格式转换为路径格式
 *
 * @param string $quote 引用格式
 * @return string $path 路径格式
 */
function lb_convert_quote_to_path($quote) {
	return lb_convert_string_format ( $quote, '.', '/' );
}

/**
 * 引用格式转换为类名路式
 *
 * @param string $quote 引用格式
 * @return string $class 类名格式
 */
function lb_convert_quote_to_class($quote) {
	return lb_convert_string_format ( $quote, '.', '_' );
}

/**
 * 字符串格式转换
 *
 * @param string $string 源字符串
 * @param string $source 源字符
 * @param string $target 目标字符
 * @return string $string 目标字符串
 */
function lb_convert_string_format($string, $source, $target) {
	// 源字符串每个部分做首字母大写处理
	foreach ( explode ( $source, $string ) as $substring ) {
		$strings [] = ucfirst ( strtolower ( $substring ) );
	}
	return implode ( $target, $strings );
}

// +------------------------------------------------------------
// | Require 文件载入
// +------------------------------------------------------------
// | 载入指定位置的PHP文件并记录到全局数组
// +------------------------------------------------------------
// | Author : yuanhang.chen@gmail.com
// +------------------------------------------------------------

/**
 * 载入应用文件
 *
 * @param string $file 文件位置
 * @param int $force 强制标记
 * @return int $require 返回状态
 */
function lb_require_app($file, $force = 0) {
	return lb_require_file ( APP_PATH, $file );
}

/**
 * 载入通用文件
 *
 * @param string $file 文件位置
 * @param int $force 强制标记
 * @return int $require 返回状态
 */
function lb_require_common($file, $force = 0) {
	return lb_require_file ( COM_PATH, $file );
}

/**
 * 载入库文件
 *
 * @param string $file 文件位置
 * @param int $force 强制标记
 * @return int $require 返回状态
 */
function lb_require_lib($file, $force = 0) {
	return lb_require_file ( LIB_PATH, $file );
}

/**
 * 载入配置文件
 *
 * @param string $file 文件位置
 * @param int $force 强制标记
 * @return int $require 返回状态
 */
function lb_require_config($file, $force = 1) {
	return lb_require_file ( CONF_PATH, $file );
}

/**
 * 载入指定文件
 *
 * @param string $prefix 路径前缀
 * @param string $file 文件位置
 * @param int $force 强制标记
 * @global array $_loaded_files 已载入文件
 * @return int $require 返回状态
 */
function lb_require_file($prefix, $file, $force = 0) {
	// 全局数组用于防止重复载入
	global $_loaded_files;
	if (! $force && in_array ( $prefix . ' ' . $file, ( array ) $_loaded_files )) {
		return 1;
	}
	// 如果文件存在则载入并记录
	if (file_exists ( $file_path = $prefix . '/' . strtolower ( lb_convert_quote_to_path ( $file ) ) . '.php' )) {
		$_loaded_files [] = $prefix . ' ' . $file;
		return require ($file_path);
	}
	return 0;
}

// +------------------------------------------------------------
// | Read 配置读取
// +------------------------------------------------------------
// | 读取系统目录和应用目录下的配置项
// +------------------------------------------------------------
// | Author : yuanhang.chen@gmail.com
// +------------------------------------------------------------

/**
 * 读取通用配置
 *
 * @param string $key 配置索引
 * @return type $config 配置值
 */
function lb_read_common($key = '') {
	return lb_read_config ( 'common', $key );
}

/**
 * 读取系统配置
 *
 * @param string $key 配置索引
 * @return type $config 配置值
 */
function lb_read_system($key = '') {
	return lb_read_config ( 'system', $key );
}

/**
 * 读取数据库配置
 *
 * @param string $key 配置索引
 * @return type $config 配置值
 */
function lb_read_database($key = '') {
	return lb_read_config ( 'database', $key );
}

/**
 * 读取静态配置
 *
 * @param string $key 配置索引
 * @return type $config 配置值
 */
function lb_read_static($key = '') {
	return lb_read_config ( 'static', $key );
}

/**
 * 读取指定配置
 *
 * @param string $group 配置组
 * @param string $key 配置索引
 * @return type $config 配置值
 */
function lb_read_config($group, $key = '') {
	// 应用配置覆盖系统配置
	$config = array_merge ( ( array ) lb_require_file ( _CONF_PATH, $group, 1 ), ( array ) lb_require_file ( CONF_PATH, $group, 1 ) );
	// 空索引则返回整个配置组
	if ($key === '') {
		return $config;
	}
	// 配置索引以点号分隔
	for($i = 0, $keys = explode ( '.', $key ); $i < count ( $keys ); $i ++) {
		$config = $config [$keys [$i]];
	}
	return $config;
}
?>