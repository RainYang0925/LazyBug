$(document).ready(function() {

	$("#img_config").unbind().attr("src", "/static/img/public/menu_config_enable.jpg");

	$("#div_menu_config").removeClass("global_menu_disable").addClass("global_menu_enable");

	load_package_list();
	load_config_list(0, "param", 1, 10);
	public_page_load(1);

	$(".package_line").hover(function() {
		$(this).find(".package_option").stop().show(300);
	}, function() {
		$(this).find(".package_option").stop().hide(300);
	});

	$(".package_line").click(function() {
		var $tree = $(this).find(".package_tree_line");
		$tree.toggle();
		if ($tree.is(":hidden")) {
			$(this).find(".package_img").find("img").attr("src", "/static/img/conf/tree_close.png");
		} else {
			$(this).find(".package_img").find("img").attr("src", "/static/img/conf/tree_open.png");
		}
	});

	$(".package_add").hover(function() {
		$(this).find("img").attr("src", "/static/img/conf/package_add_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/conf/package_add_disable.png");
	});

	$(".package_add").click(function(event) {
		event.stopPropagation();
		global_form_reset(form_package_items);
		global_form_clear(form_package_items);
		$("#input_add_package_flag").val(1);
		$("#input_edit_package_id").val("");
		global_board_show("package", 1, 1);
	});

	$(".package_edit").hover(function() {
		$(this).find("img").attr("src", "/static/img/conf/package_edit_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/conf/package_edit_disable.png");
	});

	$(".package_edit").click(function(event) {
		event.stopPropagation();
		global_form_reset(form_package_items);
		var $parent = $(this).parent().parent();
		$("#input_add_package_flag").val(0);
		$("#input_edit_package_id").val($parent.find("input[name=packageid]").val().trim());
		$("#input_packagename").val($parent.find(".package_name").find("span").text().trim());
		global_board_show("package", 1, 1);
	});

	$(".edit_package_close").click(function() {
		global_board_show("package", 0, 1);
	});

	$(".edit_package_cancel").click(function() {
		global_board_show("package", 0, 1);
	});

	$("#img_edit_package_ok").click(function() {
		if (!global_form_check(form_package_items)) {
			return;
		}
		var flag = parseInt($("#input_add_package_flag").val().trim());
		var package_id = $("#input_edit_package_id").val().trim();
		var package_name = $("#input_packagename").val().trim();
		if (flag) {
			request_package_add(package_name);
		} else {
			request_package_update(package_id, package_name);
		}
	});

	$(".package_remove").hover(function() {
		$(this).find("img").attr("src", "/static/img/conf/package_remove_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/conf/package_remove_disable.png");
	});

	$(".package_remove").click(function(event) {
		event.stopPropagation();
		var $parent = $(this).parent().parent().parent();
		$("#input_delete_package_id").val($parent.find("input[name=packageid]").val().trim());
		global_board_show("delete_package", 1, 0);
	});

	$("#img_delete_package_close").click(function() {
		global_board_show("delete_package", 0, 0);
	});

	$("#img_delete_package_cancel").click(function() {
		global_board_show("delete_package", 0, 0);
	});

	$("#img_delete_package_ok").click(function() {
		var package_id = $("#input_delete_package_id").val().trim();
		$(".package_fixed").find(".package_param").click();
		request_package_delete(package_id);
	});

	$(".package_branch").click(function(event) {
		event.stopPropagation();
		var $parent = $(this).parent().parent();
		$("#div_config_left").find(".package_info_line").removeClass("package_selected");
		$("#div_config_left").find(".package_tree_line>div").removeClass("package_tree_selected");
		$parent.find(".package_info_line").addClass("package_selected");
		$(this).addClass("package_tree_selected");
		var count = parseInt($(this).find("input[name=confignum]").val().trim());
		$("#input_page_count").val(Math.ceil(count / 10));
		$(".global_page_first").click();
	});

	$(".config_line").hover(function() {
		$(this).addClass("tr_selected");
	}, function() {
		$(this).removeClass("tr_selected");
	});

	$(".config_edit").hover(function() {
		$(this).find("img").attr("src", "/static/img/conf/config_edit_enable.png");
		$(this).find("span").addClass("config_opt_on");
	}, function() {
		$(this).find("img").attr("src", "/static/img/conf/config_edit_disable.png");
		$(this).find("span").removeClass("config_opt_on");
	});

	$(".config_edit").click(function() {
		var type = $(".package_tree_selected").find("input[name=type]").val().trim();
		var $parent = $(this).parent().parent();
		$(".div_config_branch").hide();
		$("#input_add_config_flag").val(0);
		$("#input_edit_config_id").val($parent.find("input[name=configid]").val().trim());
		$("#input_configkeyword").val($parent.find("td[class=td_config_keyword]").find("span").text().trim());
		if (type === "data") {
			global_form_reset(form_data_items);
			$("#div_config").removeClass("div_config_param").addClass("div_config_data");
			$("#div_config_data").show();
			try {
				var data = JSON.parse($parent.find("td[class=td_config_value]").find("span").text().trim());
				$("#select_configdriver").val(data[0]);
				$("#input_configdsn").val(data[1]);
			} catch (e) {
				$("#select_configdriver").val("");
				$("#input_configdsn").val("");
			}
		} else {
			global_form_reset(form_param_items);
			$("#div_config").removeClass("div_config_data").addClass("div_config_param");
			$("#div_config_param").show();
			$("#input_configvalue").val($parent.find("td[class=td_config_value]").find("span").text().trim());
		}
		global_board_show("config", 1, 1);
	});

	$(".edit_config_close").click(function() {
		global_board_show("config", 0, 1);
	});

	$(".edit_config_cancel").click(function() {
		global_board_show("config", 0, 1);
	});

	$("#img_edit_config_ok").click(function() {
		var type = $(".package_tree_selected").find("input[name=type]").val().trim();
		var flag = parseInt($("#input_add_config_flag").val().trim());
		var package_id = parseInt($(".package_selected").find("input[name=packageid]").val().trim());
		var config_type = $(".package_tree_selected").find("input[name=type]").val().trim();
		var config_id = $("#input_edit_config_id").val().trim();
		var config_keyword = $("#input_configkeyword").val().trim();
		if (type === "data") {
			if (!global_form_check(form_data_items)) {
				return;
			}
			var config_driver = $("#select_configdriver").val().trim();
			var config_dsn = $("#input_configdsn").val().trim();
			var config_value = JSON.stringify({
				0 : config_driver,
				1 : config_dsn,
			});
			if (flag) {
				request_config_add(package_id, config_type, config_keyword, config_value);
			} else {
				request_config_update(config_id, package_id, config_type, config_keyword, config_value);
			}
		} else {
			if (!global_form_check(form_param_items)) {
				return;
			}
			var config_value = $("#input_configvalue").val().trim();
			if (flag) {
				request_config_add(package_id, config_type, config_keyword, config_value);
			} else {
				request_config_update(config_id, package_id, config_type, config_keyword, config_value);
			}
		}
	});

	$(".config_remove").hover(function() {
		$(this).find("img").attr("src", "/static/img/conf/config_remove_enable.png");
		$(this).find("span").addClass("config_opt_on");
	}, function() {
		$(this).find("img").attr("src", "/static/img/conf/config_remove_disable.png");
		$(this).find("span").removeClass("config_opt_on");
	});

	$(".config_remove").click(function() {
		var $parent = $(this).parent().parent();
		$("#input_delete_config_id").val($parent.find("input[name=configid]").val().trim());
		global_board_show("delete_config", 1, 0);
	});

	$("#img_delete_config_close").click(function() {
		global_board_show("delete_config", 0, 0);
	});

	$("#img_delete_config_cancel").click(function() {
		global_board_show("delete_config", 0, 0);
	});

	$("#img_delete_config_ok").click(function() {
		var config_id = $("#input_delete_config_id").val().trim();
		request_config_delete(config_id);
	});

	$("#span_config_add").hover(function() {
		$(this).addClass("add_on");
	}, function() {
		$(this).removeClass("add_on");
	});

	$("#span_config_add").click(function() {
		var type = $(".package_tree_selected").find("input[name=type]").val().trim();
		$(".div_config_branch").hide();
		$("#input_add_config_flag").val(1);
		$("#input_edit_config_id").val("");
		if (type === "data") {
			global_form_reset(form_data_items);
			global_form_clear(form_data_items);
			$("#div_config").removeClass("div_config_param").addClass("div_config_data");
			$("#div_config_data").show();
		} else {
			global_form_reset(form_param_items);
			global_form_clear(form_param_items);
			$("#div_config").removeClass("div_config_data").addClass("div_config_param");
			$("#div_config_param").show();
		}
		global_board_show("config", 1, 1);
	});
});