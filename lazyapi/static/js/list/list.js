$(document).ready(function() {

	$("#img_list").unbind().attr("src", "/static/img/public/menu_list_enable.jpg");

	$("#div_menu_list").removeClass("global_menu_disable").addClass("global_menu_enable");

	load_module_list();
	load_item_list(0, 1, 10);
	public_page_load(1);

	$(".module_line").hover(function() {
		$(this).find(".module_tag").addClass("module_tag_selected");
		$(this).find(".module_option").stop().show(300);
	}, function() {
		$(this).find(".module_tag").removeClass("module_tag_selected");
		$(this).find(".module_option").stop().hide(300);
	});

	$(".module_line").click(function() {
		$(".module_tag_open").removeClass("module_tag_open");
		$(".module_tag_selected").removeClass("module_tag_selected");
		$(".module_selected").removeClass("module_selected");
		$(".count_num_on").removeClass("count_num_on");
		$(this).find(".module_tag").addClass("module_tag_open");
		$(this).find(".module_detail").addClass("module_selected");
		$(this).find(".count_num_item").addClass("count_num_on");
		$(this).find(".count_num_case").addClass("count_num_on");
		var count = parseInt($(this).find("input[name=itemnum]").val().trim());
		$("#input_page_count").val(Math.ceil(count / 10));
		$(".global_page_first").click();
	});

	$(".module_add").hover(function() {
		$(this).find("img").attr("src", "/static/img/list/module_add_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/list/module_add_disable.png");
	});

	$(".module_add").click(function(event) {
		event.stopPropagation();
		global_form_reset(form_module_items);
		global_form_clear(form_module_items);
		$("#input_add_module_flag").val(1);
		$("#input_edit_module_id").val("");
		global_board_show("module", 1, 1);
	});

	$(".module_edit").hover(function() {
		$(this).find("img").attr("src", "/static/img/list/module_edit_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/list/module_edit_disable.png");
	});

	$(".module_edit").click(function(event) {
		event.stopPropagation();
		global_form_reset(form_module_items);
		var $parent = $(this).parent().parent().parent();
		$("#input_add_module_flag").val(0);
		$("#input_edit_module_id").val($parent.find("input[name=moduleid]").val().trim());
		$("#input_modulename").val($parent.find(".module_name").find("span").text().trim());
		global_board_show("module", 1, 1);
	});

	$(".edit_module_close").click(function() {
		global_board_show("module", 0, 1);
	});

	$(".edit_module_cancel").click(function() {
		global_board_show("module", 0, 1);
	});

	$("#img_edit_module_ok").click(function() {
		if (!global_form_check(form_module_items)) {
			return;
		}
		var flag = parseInt($("#input_add_module_flag").val().trim());
		var module_id = $("#input_edit_module_id").val().trim();
		var module_name = $("#input_modulename").val().trim();
		if (flag) {
			request_module_add(module_name);
		} else {
			request_module_update(module_id, module_name);
		}
	});

	$(".module_remove").hover(function() {
		$(this).find("img").attr("src", "/static/img/list/module_remove_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/list/module_remove_disable.png");
	});

	$(".module_remove").click(function(event) {
		event.stopPropagation();
		var $parent = $(this).parent().parent().parent();
		$("#input_delete_module_id").val($parent.find("input[name=moduleid]").val().trim());
		global_board_show("delete_module", 1, 0);
	});

	$("#img_delete_module_close").click(function() {
		global_board_show("delete_module", 0, 0);
	});

	$("#img_delete_module_cancel").click(function() {
		global_board_show("delete_module", 0, 0);
	});

	$("#img_delete_module_ok").click(function() {
		var module_id = $("#input_delete_module_id").val().trim();
		$(".module_fixed").click();
		request_module_delete(module_id);
	});

	$(".item_line").hover(function() {
		$(this).addClass("tr_selected");
	}, function() {
		$(this).removeClass("tr_selected");
	});

	$(".item_line").click(function() {
		var $next = $(this).next(".item_case_line");
		if ($next.length) {
			$next.toggle();
		} else {
			var item_id = $(this).find("input[name=itemid]").val().trim();
			var module_id = $(this).find("input[name=moduleid]").val().trim();
			var $new_item_case = $(".item_case_tmp").clone(true);
			$new_item_case.removeClass("item_case_tmp").attr("id", "tr_item_case_" + item_id);
			$new_item_case.find(".case_add").find("input[name=itemid]").val(item_id);
			$new_item_case.find(".case_add").find("input[name=moduleid]").val(module_id);
			$(this).after($new_item_case);
			$new_item_case.show();
			load_case_list($(this));
		}
		if ($next.is(":hidden")) {
			$(this).find(".td_item_name").find("img").attr("src", "/static/img/list/fade_in.png");
			$(this).removeClass("tr_open");
		} else {
			$(this).find(".td_item_name").find("img").attr("src", "/static/img/list/fade_out.png");
			$(this).addClass("tr_open");
		}
	});

	$(".item_edit").hover(function() {
		$(this).find("img").attr("src", "/static/img/list/item_edit_enable.png");
		$(this).find("span").addClass("item_opt_on");
	}, function() {
		$(this).find("img").attr("src", "/static/img/list/item_edit_disable.png");
		$(this).find("span").removeClass("item_opt_on");
	});

	$(".item_edit").click(function(event) {
		event.stopPropagation();
		global_form_reset(form_item_items);
		var $parent = $(this).parent().parent();
		$("#input_add_item_flag").val(0);
		$("#input_edit_item_id").val($parent.find("input[name=itemid]").val().trim());
		$("#input_itemname").val($parent.find("td[class=td_item_name]").find("span").text().trim());
		$("#input_itemurl").val($parent.find("input[name=itemurl]").val().trim());
		global_board_show("item", 1, 1);
	});

	$(".edit_item_close").click(function() {
		global_board_show("item", 0, 1);
	});

	$(".edit_item_cancel").click(function() {
		global_board_show("item", 0, 1);
	});

	$("#img_edit_item_ok").click(function() {
		if (!global_form_check(form_item_items)) {
			return;
		}
		var flag = parseInt($("#input_add_item_flag").val().trim());
		var module_id = parseInt($(".module_selected").find("input[name=moduleid]").val().trim());
		var item_id = $("#input_edit_item_id").val().trim();
		var item_name = $("#input_itemname").val().trim();
		var item_url = $("#input_itemurl").val().trim();
		if (flag) {
			request_item_add(module_id, item_name, item_url);
		} else {
			request_item_update(item_id, item_name, item_url);
		}
	});

	$(".item_remove").hover(function() {
		$(this).find("img").attr("src", "/static/img/list/item_remove_enable.png");
		$(this).find("span").addClass("item_opt_on");
	}, function() {
		$(this).find("img").attr("src", "/static/img/list/item_remove_disable.png");
		$(this).find("span").removeClass("item_opt_on");
	});

	$(".item_remove").click(function(event) {
		event.stopPropagation();
		var $parent = $(this).parent().parent();
		$("#input_delete_item_id").val($parent.find("input[name=itemid]").val().trim());
		global_board_show("delete_item", 1, 0);
	});

	$("#img_delete_item_close").click(function() {
		global_board_show("delete_item", 0, 0);
	});

	$("#img_delete_item_cancel").click(function() {
		global_board_show("delete_item", 0, 0);
	});

	$("#img_delete_item_ok").click(function() {
		var item_id = $("#input_delete_item_id").val().trim();
		request_item_delete(item_id);
	});

	$("#span_item_add").hover(function() {
		$(this).addClass("add_on");
	}, function() {
		$(this).removeClass("add_on");
	});

	$("#span_item_add").click(function() {
		global_form_reset(form_item_items);
		global_form_clear(form_item_items);
		$("#input_add_item_flag").val(1);
		$("#input_edit_item_id").val("");
		global_board_show("item", 1, 1);
	});

	$(".case_line").hover(function() {
		$(this).find(".icon_item").stop().fadeIn(300);
	}, function() {
		$(this).find(".icon_item").stop().fadeOut(300);
	});

	$(".case_level").hover(function() {
		$(this).find("img").attr("src", "/static/img/list/case_level_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/list/case_level_disable.png");
	});

	$(".case_level").click(function() {
		var $parent = $(this).parent().parent().parent();
		var case_id = $parent.find("input[name=caseid]").val().trim();
		var case_level = $parent.find("input[name=caselevel]").val().trim();
		$("#input_level_case_id").val(case_id);
		$(".level_item").removeClass("level_lock").stop().fadeTo(0, 0.3);
		$("#div_level_" + case_level).addClass("level_lock").stop().fadeTo(0, 1);
		global_board_show("case_level", 1, 0);
	});

	$(".level_item").hover(function() {
		$(this).stop().fadeTo(300, 1);
	}, function() {
		if (!$(this).hasClass("level_lock")) {
			$(this).stop().fadeTo(300, 0.3);
		}
	});

	$(".level_item").click(function() {
		var case_id = $("#input_level_case_id").val().trim();
		var case_level = $(this).find(".select_level").val().trim();
		request_case_level(case_id, case_level);
	});

	$("#img_case_level_close").click(function() {
		global_board_show("case_level", 0, 0);
	});

	$(".case_edit").hover(function() {
		$(this).find("img").attr("src", "/static/img/list/case_edit_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/list/case_edit_disable.png");
	});

	$(".case_edit").click(function() {
		global_form_reset(form_case_items);
		var $parent = $(this).parent().parent().parent();
		$("#input_add_case_flag").val(0);
		$("#input_edit_case_item_id").val("");
		$("#input_edit_case_module_id").val("");
		$("#input_edit_case_id").val($parent.find("input[name=caseid]").val().trim());
		$("#input_casename").val($parent.find("input[name=casename]").val().trim());
		$("#select_sendtype").val($parent.find("input[name=sendtype]").val().trim());
		$("#input_requestparam").val($parent.find("input[name=requestparam]").val().trim());
		$("#input_responseheader").val($parent.find("textarea[name=responseheader]").val().trim());
		global_board_show("case", 1, 1);
	});

	$(".edit_case_close").click(function() {
		global_board_show("case", 0, 1);
	});

	$(".edit_case_cancel").click(function() {
		global_board_show("case", 0, 1);
	});

	$("#img_edit_case_ok").click(function() {
		if (!global_form_check(form_case_items)) {
			return;
		}
		var flag = parseInt($("#input_add_case_flag").val().trim());
		var item_id = $("#input_edit_case_item_id").val().trim();
		var module_id = $("#input_edit_case_module_id").val().trim();
		var case_id = $("#input_edit_case_id").val().trim();
		var case_name = $("#input_casename").val().trim();
		var send_type = $("#select_sendtype").val().trim();
		var request_param = $("#input_requestparam").val().trim();
		var response_header = $("#input_responseheader").val().trim();
		if (flag) {
			request_case_add(item_id, module_id, case_name, send_type, request_param, response_header);
		} else {
			request_case_update(case_id, case_name, send_type, request_param, response_header);
		}
	});

	$(".case_load").hover(function() {
		$(this).find("img").attr("src", "/static/img/list/case_load_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/list/case_load_disable.png");
	});

	$(".case_load").click(function() {
		var $parent = $(this).parent().parent().parent();
		var case_id = $parent.find("input[name=caseid]").val().trim();
		window.location.href = "/index.php/start?reload=" + case_id;
	});

	$(".case_sort").hover(function() {
		$(this).find("img").attr("src", "/static/img/list/case_sort_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/list/case_sort_disable.png");
	});

	$(".case_sort").click(function() {
		var $parent = $(this).parent().parent().parent()
		var case_id = $parent.find("input[name=caseid]").val().trim();
		window.location.href = "/index.php/sort?id=" + case_id;
	});

	$(".case_remove").hover(function() {
		$(this).find("img").attr("src", "/static/img/list/case_remove_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/list/case_remove_disable.png");
	});

	$(".case_remove").click(function() {
		var $parent = $(this).parent().parent().parent();
		$("#input_delete_case_id").val($parent.find("input[name=caseid]").val().trim());
		global_board_show("delete_case", 1, 0);
	});

	$("#img_delete_case_close").click(function() {
		global_board_show("delete_case", 0, 0);
	});

	$("#img_delete_case_cancel").click(function() {
		global_board_show("delete_case", 0, 0);
	});

	$("#img_delete_case_ok").click(function() {
		var case_id = $("#input_delete_case_id").val().trim();
		request_case_delete(case_id);
	});

	$(".span_case_add").hover(function() {
		$(this).addClass("add_on");
	}, function() {
		$(this).removeClass("add_on");
	});

	$(".span_case_add").click(function() {
		global_form_reset(form_case_items);
		global_form_clear(form_case_items);
		var $parent = $(this).parent();
		$("#input_add_case_flag").val(1);
		$("#input_edit_case_item_id").val($parent.find("input[name=itemid]").val().trim());
		$("#input_edit_case_module_id").val($parent.find("input[name=moduleid]").val().trim());
		$("#input_edit_case_id").val("");
		global_board_show("case", 1, 1);
	});
});