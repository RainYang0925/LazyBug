$(document).ready(function() {

	$("#img_user").unbind().attr("src", "/static/img/public/menu_user_enable.jpg");

	$("#div_menu_user").removeClass("global_menu_disable").addClass("global_menu_enable");

	load_user_list(1, 10);
	public_page_load(1);

	$(".user_line").hover(function() {
		$(this).addClass("tr_selected");
	}, function() {
		$(this).removeClass("tr_selected");
	});

	$(".user_edit").hover(function() {
		$(this).find("img").attr("src", "/static/img/user/user_edit_enable.png");
		$(this).find("span").addClass("user_opt_on");
	}, function() {
		$(this).find("img").attr("src", "/static/img/user/user_edit_disable.png");
		$(this).find("span").removeClass("user_opt_on");
	});

	$(".user_edit").click(function() {
		global_form_reset(form_user_items);
		var $parent = $(this).parent().parent();
		$("#input_add_user_flag").val(0);
		$("#input_edit_user_id").val($parent.find("input[name=userid]").val().trim());
		$("#input_username").attr("readonly", "true").addClass("global_input_disable");
		$("#input_username").val($parent.find("td[class=td_user_name]").find("span").text().trim());
		$("#input_userpassword").val("");
		if ($("#input_username").val().trim() === "admin") {
			$("#select_userrole").attr("disabled", "true").addClass("global_input_disable");
		} else {
			$("#select_userrole").removeAttr("disabled").removeClass("global_input_disable");
		}
		$("#select_userrole").val($parent.find("input[name=userrole]").val().trim());
		global_board_show("user", 1, 1);
	});

	$(".edit_user_close").click(function() {
		global_board_show("user", 0, 1);
	});

	$(".edit_user_cancel").click(function() {
		global_board_show("user", 0, 1);
	});

	$("#img_edit_user_ok").click(function() {
		if (!global_form_check(form_user_items)) {
			return;
		}
		var flag = parseInt($("#input_add_user_flag").val().trim());
		var user_id = $("#input_edit_user_id").val().trim();
		var user_name = $("#input_username").val().trim();
		var user_password = $("#input_userpassword").val().trim();
		var user_role = $("#select_userrole").val().trim();
		if (flag) {
			request_user_add(user_name, user_password, user_role);
		} else {
			request_user_update(user_id, user_name, user_password, user_role);
		}
	});

	$(".user_remove").hover(function() {
		$(this).find("img").attr("src", "/static/img/user/user_remove_enable.png");
		$(this).find("span").addClass("user_opt_on");
	}, function() {
		$(this).find("img").attr("src", "/static/img/user/user_remove_disable.png");
		$(this).find("span").removeClass("user_opt_on");
	});

	$(".user_remove").click(function() {
		var $parent = $(this).parent().parent();
		$("#input_delete_user_id").val($parent.find("input[name=userid]").val().trim());
		global_board_show("delete_user", 1, 0);
	});

	$("#img_delete_user_close").click(function() {
		global_board_show("delete_user", 0, 0);
	});

	$("#img_delete_user_cancel").click(function() {
		global_board_show("delete_user", 0, 0);
	});

	$("#img_delete_user_ok").click(function() {
		var user_id = $("#input_delete_user_id").val().trim();
		request_user_delete(user_id);
	});

	$("#span_user_add").hover(function() {
		$(this).addClass("add_on");
	}, function() {
		$(this).removeClass("add_on");
	});

	$("#span_user_add").click(function() {
		global_form_reset(form_user_items);
		global_form_clear(form_user_items);
		$("#input_add_user_flag").val(1);
		$("#input_edit_user_id").val("");
		$("#input_username").removeAttr("readonly").removeClass("global_input_disable");
		$("#select_userrole").removeAttr("disabled").removeClass("global_input_disable");
		global_board_show("user", 1, 1);
	});
});