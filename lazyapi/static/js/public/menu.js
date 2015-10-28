$(document).ready(function() {
	public_menu_switch("start");
	public_menu_switch("list");
	public_menu_switch("run");
	public_menu_switch("history");
	public_menu_switch("user");
	public_menu_switch("config");
});

public_menu_switch = function(menu) {
	$("#img_" + menu).hover(function() {
		$(this).attr("src", "/static/img/public/menu_" + menu + "_enable.jpg");
		$("#div_menu_" + menu).removeClass("global_menu_disable").addClass("global_menu_enable");
	}, function() {
		$(this).attr("src", "/static/img/public/menu_" + menu + "_disable.jpg");
		$("#div_menu_" + menu).removeClass("global_menu_enable").addClass("global_menu_disable");
	});
}