<?php
// +------------------------------------------------------------
// | Other 其他函数
// +------------------------------------------------------------
// | 文件自动载入和快捷函数
// +------------------------------------------------------------
// | Author : yuanhang.chen@gmail.com
// +------------------------------------------------------------

/**
 * 自动载入
 *
 * @param string $class 载入类名
 */
function __autoload($class) {
	// 搜索应用库文件目录和系统库文件目录
	if (! lb_require_lib ( lb_convert_class_to_quote ( $class ) )) {
		lb_require_file ( _LIB_PATH, lb_convert_class_to_quote ( str_replace ( '/^Lb_/', '', $class ) ) );
	}
}

/**
 * 快捷模型
 *
 * @param string $name 模型名称
 * @return object $model 模型对象
 */
function M($name) {
	// 模型存在时创建对象
	if (lb_require_lib ( 'Model.' . $name )) {
		$model_class = 'Model_' . lb_convert_quote_to_class ( $name );
		return new $model_class ();
	}
}

/**
 * 快捷视图
 *
 * @param string $name 视图名称
 * @return object $view 视图对象
 */
function V($name) {
	// 视图存在时创建对象
	if (lb_require_lib ( 'View.' . $name )) {
		$view_class = 'View_' . lb_convert_quote_to_class ( $name );
		return new $view_class ();
	}
}
?>