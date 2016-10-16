<?php

namespace Lazybug\Framework;

// +------------------------------------------------------------
// | Router 映射路由器
// +------------------------------------------------------------
// | 根据路由配置将请求地址映射到控制器
// +------------------------------------------------------------
// | Author : yuanhang.chen@gmail.com
// +------------------------------------------------------------
class Mod_Router_Mapping extends Lb_Router {

	/**
	 * 地址解析
	 *
	 * @access public
	 * @return string $controller 控制器
	 */
	public function dispatch() {
		$request = parse_url ( strtolower ( preg_replace ( '/\/$/', '', $_SERVER ['REQUEST_URI'] ) ) );
		$path = preg_replace ( '/^\/index.php/', '', $request ['path'] );
		foreach ( ( array ) lb_read_config ( 'intercept' ) as $intercepter => $url ) {
			if (preg_match ( '/^' . str_replace ( '/', '\/', $url ) . '$/', $path )) {
				if (! is_null ( $controller = lb_call_intercepter ( $intercepter ) )) {
					return $controller;
				}
			}
		}
		foreach ( ( array ) lb_read_config ( 'route' ) as $controller => $url ) {
			if (preg_match ( '/^' . str_replace ( '/', '\/', $url ) . '$/', $path )) {
				return $controller;
			}
		}
	}
}
?>