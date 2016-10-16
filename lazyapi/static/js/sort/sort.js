$(document).ready(function() {

	$("#img_list").unbind().attr("src", "/static/img/public/menu_list_enable.jpg");

	$("#div_menu_list").removeClass("global_menu_disable").addClass("global_menu_enable");

	step_line_id = 1;
	$("#div_sortable").sortable({
		change : function(event, ui) {
			change_status(0);
		},
		cancel : ".result_line"
	});
	reload();

	$(".step_line").hover(function() {
		$(this).find(".step_option").stop().fadeIn(100);
	}, function() {
		$(this).find(".step_option").stop().fadeOut(100);
	});

	$(".icon_up").click(function() {
		var $parent = $(this).parent().parent().parent().parent();
		var $prev = $parent.prev(".step_line:not(.step_tmp)");
		if ($prev[0] === null) {
			return;
		}
		$new_step = $parent.clone(true);
		$new_step.find(".step_option").hide();
		$prev.before($new_step);
		$parent.remove();
		change_status(0);
	});

	$(".icon_down").click(function() {
		var $parent = $(this).parent().parent().parent().parent();
		var $next = $parent.next(".step_line:not(.step_tmp)");
		if ($next[0] === null) {
			return;
		}
		$new_step = $parent.clone(true);
		$new_step.find(".step_option").hide();
		$next.after($new_step);
		$parent.remove();
		change_status(0);
	});

	$(".icon_edit").click(function() {
		var $parent = $(this).parent().parent().parent().parent();
		var step_id = $parent.attr("id");
		var step_type = $parent.find(".step_type").find("span").text().trim();
		var step_name = $parent.find(".step_name").find("span").text().trim();
		var step_command = $parent.find(".step_type").find("input[name=stepcommand]").val().trim();
		var step_fliter = $parent.find(".step_type").find("input[name=stepfliter]").val().trim();
		var step_value = $parent.find(".step_type").find("input[name=stepvalue]").val().trim();
		switch (step_type) {
		case "检查点":
			global_form_reset(form_check_items);
			$("#input_check_step_id").val(step_id);
			$("#input_add_check_flag").val(0);
			$("#input_checkname").val(step_name);
			$("#input_checkcommand").val(step_command);
			$("#input_checkfliter").val(step_fliter);
			$("#input_checkvalue").val(step_value);
			set_check_option();
			global_board_show("check", 1, 0);
			break;
		case "接口调用":
			var space_id = parseInt($("#input_space_id").val());
			global_form_reset(form_call_items);
			$("#input_call_step_id").val(step_id);
			$("#input_add_call_flag").val(0);
			$("#input_callname").val(step_name);
			global_board_show("call", 1, 0);
			load_module_list(space_id);
			break;
		case "存储查询":
			global_form_reset(form_store_items);
			$("#input_store_step_id").val(step_id);
			$("#input_add_store_flag").val(0);
			$("#input_storename").val(step_name);
			$("#input_storecommand").val(step_command);
			$("#input_storevalue").val(step_value);
			$("#input_storeconfig").val(step_command.replace("config:", ""));
			global_board_show("store", 1, 0);
			break;
		default:
		}
	});

	$(".step_option_add").hover(function() {
		$(this).find(".step_option_more").stop().slideDown(300);
	}, function() {
		$(this).find(".step_option_more").stop().slideUp(300);
	});

	$(".step_option_add").click(function() {
		$(this).find(".icon_add_check").click();
	});

	$(".icon_add_check").click(function(event) {
		event.stopPropagation();
		global_form_reset(form_check_items);
		global_form_clear(form_check_items);
		var $parent = $(this).parent().parent().parent().parent().parent();
		$("#input_check_step_id").val($parent.attr("id"));
		$("#input_add_check_flag").val(1);
		global_board_show("check", 1, 0);
	});

	$(".edit_check_close").click(function() {
		global_board_show("check", 0, 0);
	});

	$(".edit_check_cancel").click(function() {
		global_board_show("check", 0, 0);
	});

	$("#checkbox_checkall").click(function() {
		if ($("#checkbox_checkall").prop("checked")) {
			$("#checkbox_checkbegin").prop("checked", false);
			$("#checkbox_checkend").prop("checked", false);
		}
	});

	$("#checkbox_checkbegin").click(function() {
		if ($("#checkbox_checkbegin").prop("checked")) {
			$("#checkbox_checkall").prop("checked", false);
		}
	});

	$("#checkbox_checkend").click(function() {
		if ($("#checkbox_checkend").prop("checked")) {
			$("#checkbox_checkall").prop("checked", false);
		}
	});

	$("#img_edit_check_ok").click(function() {
		if (!global_form_check(form_check_items)) {
			return;
		}
		$("#input_checkcommand").val(get_check_option());
		var step_id = $("#input_check_step_id").val().trim();
		var flag = parseInt($("#input_add_check_flag").val().trim());
		var check_name = $("#input_checkname").val().trim();
		var check_command = $("#input_checkcommand").val().trim();
		var check_fliter = $("#input_checkfliter").val().trim();
		var check_value = $("#input_checkvalue").val().trim();
		if (flag) {
			var $new_step = $(".step_tmp").clone(true);
			$new_step.removeClass("step_tmp").attr("id", "div_step_" + step_line_id++);
			$new_step.find(".step_type").find("img").attr("src", "/static/img/sort/step_check.png");
			$new_step.find(".step_type").find("span").text("检查点");
			$new_step.find("input[name=stepcommand]").val(check_command);
			$new_step.find("input[name=stepfliter]").val(check_fliter);
			$new_step.find("input[name=stepvalue]").val(check_value);
			$new_step.find(".step_name").find("span").text(check_name);
			$new_step.show();
			$("#" + step_id).after($new_step);
			change_status(0);
			global_board_show("check", 0, 0);
		} else {
			$("#" + step_id).find("input[name=stepcommand]").val(check_command);
			$("#" + step_id).find("input[name=stepfliter]").val(check_fliter);
			$("#" + step_id).find("input[name=stepvalue]").val(check_value);
			$("#" + step_id).find(".step_name").find("span").text(check_name);
			change_status(0);
			global_board_show("check", 0, 0);
		}
	});

	$(".icon_add_call").click(function(event) {
		event.stopPropagation();
		global_form_reset(form_call_items);
		global_form_clear(form_call_items);
		var space_id = parseInt($("#input_space_id").val());
		var $parent = $(this).parent().parent().parent().parent().parent();
		$("#input_call_step_id").val($parent.attr("id"));
		$("#input_add_call_flag").val(1);
		global_board_show("call", 1, 0);
		load_module_list(space_id);
	});

	$("#select_callmodule").change(function() {
		var space_id = parseInt($("#input_space_id").val());
		load_item_list(space_id, $(this).val().trim());
	});

	$("#select_callitem").change(function() {
		load_case_list($(this).val().trim());
	});

	$(".edit_call_close").click(function() {
		global_board_show("call", 0, 0);
	});

	$(".edit_call_cancel").click(function() {
		global_board_show("call", 0, 0);
	});

	$("#img_edit_call_ok").click(function() {
		if (!global_form_check(form_call_items)) {
			return;
		}
		var step_id = $("#input_call_step_id").val().trim();
		var flag = parseInt($("#input_add_call_flag").val().trim());
		var call_name = $("#input_callname").val().trim();
		var call_value = parseInt($("#select_callcase").val());
		if (flag) {
			var $new_step = $(".step_tmp").clone(true);
			$new_step.removeClass("step_tmp").attr("id", "div_step_" + step_line_id++);
			$new_step.find(".step_type").find("img").attr("src", "/static/img/sort/step_call.png");
			$new_step.find(".step_type").find("span").text("接口调用");
			$new_step.find("input[name=stepvalue]").val(call_value);
			$new_step.find(".step_name").find("span").text(call_name);
			$new_step.show();
			$("#" + step_id).after($new_step);
			change_status(0);
			global_board_show("call", 0, 0);
		} else {
			$("#" + step_id).find("input[name=stepvalue]").val(call_value);
			$("#" + step_id).find(".step_name").find("span").text(call_name);
			change_status(0);
			global_board_show("call", 0, 0);
		}
	});

	$(".icon_add_store").click(function(event) {
		event.stopPropagation();
		global_form_reset(form_store_items);
		global_form_clear(form_store_items);
		var $parent = $(this).parent().parent().parent().parent().parent();
		$("#input_store_step_id").val($parent.attr("id"));
		$("#input_add_store_flag").val(1);
		global_board_show("store", 1, 0);
	});

	$(".edit_store_close").click(function() {
		global_board_show("store", 0, 0);
	});

	$(".edit_store_cancel").click(function() {
		global_board_show("store", 0, 0);
	});

	$("#img_edit_store_ok").click(function() {
		if (!global_form_check(form_store_items)) {
			return;
		}
		$("#input_storecommand").val("config:" + $("#input_storeconfig").val().trim());
		var step_id = $("#input_store_step_id").val().trim();
		var flag = parseInt($("#input_add_store_flag").val().trim());
		var store_name = $("#input_storename").val().trim();
		var store_command = $("#input_storecommand").val().trim();
		var store_value = $("#input_storevalue").val().trim();
		if (flag) {
			var $new_step = $(".step_tmp").clone(true);
			$new_step.removeClass("step_tmp").attr("id", "div_step_" + step_line_id++);
			$new_step.find(".step_type").find("img").attr("src", "/static/img/sort/step_store.png");
			$new_step.find(".step_type").find("span").text("存储查询");
			$new_step.find("input[name=stepcommand]").val(store_command);
			$new_step.find("input[name=stepvalue]").val(store_value);
			$new_step.find(".step_name").find("span").text(store_name);
			$new_step.show();
			$("#" + step_id).after($new_step);
			change_status(0);
			global_board_show("store", 0, 0);
		} else {
			$("#" + step_id).find("input[name=stepcommand]").val(store_command);
			$("#" + step_id).find("input[name=stepvalue]").val(store_value);
			$("#" + step_id).find(".step_name").find("span").text(store_name);
			change_status(0);
			global_board_show("store", 0, 0);
		}
	});

	$(".edit_option_close").click(function() {
		global_board_show("option", 0, 0);
	});

	$(".edit_option_cancel").click(function() {
		global_board_show("option", 0, 0);
	});

	$("#img_edit_option_ok").click(function() {
		var guid = new Date().getTime() + "-" + parseInt(10 * Math.random()) + parseInt(10 * Math.random()) + parseInt(10 * Math.random());
		var package_id = parseInt($("#select_optionpackage").val());
		$(".result_line:not(.result_tmp)").remove();
		change_status(-1);
		global_board_show("option", 0, 0);
		run_step(0, package_id, guid, "");
	});

	$(".icon_delete").click(function() {
		var $parent = $(this).parent().parent().parent().parent();
		$parent.remove();
		change_status(0);
	});

	$("#img_save").click(function() {
		change_status(-1);
		var reload_id = $("#input_reload_id").val().trim();
		request_step_save(reload_id);
	});

	$("#img_test").click(function() {
		global_board_show("option", 1, 0);
		load_package_list();
	});

	$("#img_clear").click(function() {
		$(".result_line:not(.result_tmp)").remove();
	});
});