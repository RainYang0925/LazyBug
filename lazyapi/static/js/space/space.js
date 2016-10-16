$(document).ready(function() {

	$("#img_list").unbind().attr("src", "/static/img/public/menu_list_enable.jpg");

	$("#div_menu_list").removeClass("global_menu_disable").addClass("global_menu_enable");

	load_space_list();

	$(".space_line").hover(function() {
		$(this).find(".space_option").stop().show(300);
	}, function() {
		$(this).find(".space_option").stop().hide(300);
	});

	$(".space_add").hover(function() {
		$(this).find("img").attr("src", "/static/img/space/space_add_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/space/space_add_disable.png");
	});

	$(".space_add").click(function() {
		global_form_reset(form_space_items);
		global_form_clear(form_space_items);
		$("#input_add_space_flag").val(1);
		$("#input_edit_space_id").val("");
		global_board_show("space", 1, 1);
	});

	$(".space_edit").hover(function() {
		$(this).find("img").attr("src", "/static/img/space/space_edit_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/space/space_edit_disable.png");
	});

	$(".space_edit").click(function() {
		global_form_reset(form_space_items);
		var $parent = $(this).parent().parent();
		$("#input_add_space_flag").val(0);
		$("#input_edit_space_id").val($parent.find("input[name=spaceid]").val().trim());
		$("#input_spacename").val($parent.find(".space_name").find("span").text().trim());
		global_board_show("space", 1, 1);
	});

	$(".edit_space_close").click(function() {
		global_board_show("space", 0, 1);
	});

	$(".edit_space_cancel").click(function() {
		global_board_show("space", 0, 1);
	});

	$("#img_edit_space_ok").click(function() {
		if (!global_form_check(form_space_items)) {
			return;
		}
		var flag = parseInt($("#input_add_space_flag").val().trim());
		var space_id = $("#input_edit_space_id").val().trim();
		var space_name = $("#input_spacename").val().trim();
		if (flag) {
			request_space_add(space_name);
		} else {
			request_space_update(space_id, space_name);
		}
	});

	$(".space_remove").hover(function() {
		$(this).find("img").attr("src", "/static/img/space/space_remove_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/space/space_remove_disable.png");
	});

	$(".space_remove").click(function() {
		var $parent = $(this).parent().parent();
		$("#input_delete_space_id").val($parent.find("input[name=spaceid]").val().trim());
		global_board_show("delete_space", 1, 0);
	});

	$("#img_delete_space_close").click(function() {
		global_board_show("delete_space", 0, 0);
	});

	$("#img_delete_space_cancel").click(function() {
		global_board_show("delete_space", 0, 0);
	});

	$("#img_delete_space_ok").click(function() {
		var space_id = $("#input_delete_space_id").val().trim();
		request_space_delete(space_id);
	});
});