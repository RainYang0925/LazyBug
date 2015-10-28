$(document).ready(function() {

	$("#img_run").unbind().attr("src", "/static/img/public/menu_run_enable.jpg");

	$("#div_menu_run").removeClass("global_menu_disable").addClass("global_menu_enable");

	load_task_list(1, 10, 3);
	load_package_list();
	load_module_list();
	public_page_load(1);
	setTimeout("sync_task_status()", 5000);

	$(".task_line").hover(function() {
		$(this).addClass("task_selected");
	}, function() {
		$(this).removeClass("task_selected");
	});

	$(".task_run").hover(function() {
		$(this).find("img").attr("src", $(this).find("img").attr("src").replace("disable", "enable"));
	}, function() {
		$(this).find("img").attr("src", $(this).find("img").attr("src").replace("enable", "disable"));
	});

	$(".task_run").click(function() {
		var $parent = $(this).parent().parent().parent();
		var task_id = $parent.find("input[name=taskid]").val().trim();
		if ($(this).find("img").attr("src") === "/static/img/run/task_run_enable.png") {
			request_job_add(task_id);
		} else {
			request_job_delete(task_id);
		}
	});

	$(".task_add").hover(function() {
		$(this).find("img").attr("src", "/static/img/run/task_add_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/run/task_add_disable.png");
	});

	$(".task_add").click(function() {
		global_form_reset(form_task_items);
		global_form_clear(form_task_items);
		$("#input_add_task_flag").val(1);
		$("#input_edit_task_id").val("");
		global_board_show("task", 1, 1);
	});

	$(".task_edit").hover(function() {
		$(this).find("img").attr("src", "/static/img/run/task_edit_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/run/task_edit_disable.png");
	});

	$(".task_edit").click(function() {
		global_form_reset(form_task_items);
		var $parent = $(this).parent().parent().parent();
		var task_runtime = $parent.find("input[name=taskruntime]").val().trim().split("-");
		$("#input_add_task_flag").val(0);
		$("#input_edit_task_id").val($parent.find("input[name=taskid]").val().trim());
		$("#input_taskname").val($parent.find("div[class=task_name]").find("span").text().trim());
		$("#select_taskpackage").val($parent.find("input[name=packageid]").val().trim());
		$("#select_taskmodule").val($parent.find("input[name=moduleid]").val().trim());
		$("#select_tasklevel").val($parent.find("input[name=tasklevel]").val().trim());
		if (task_runtime.length === 2) {
			$("#select_taskhour").val(task_runtime[0]);
			$("#select_taskminute").val(task_runtime[1]);
		}
		global_board_show("task", 1, 1);
	});

	$(".edit_task_close").click(function() {
		global_board_show("task", 0, 1);
	});

	$(".edit_task_cancel").click(function() {
		global_board_show("task", 0, 1);
	});

	$("#img_edit_task_ok").click(function() {
		if (!global_form_check(form_task_items)) {
			return;
		}
		var flag = parseInt($("#input_add_task_flag").val().trim());
		var task_id = $("#input_edit_task_id").val().trim();
		var task_name = $("#input_taskname").val().trim();
		var task_package = $("#select_taskpackage").val().trim();
		var task_module = $("#select_taskmodule").val().trim();
		var task_level = $("#select_tasklevel").val().trim();
		var task_runtime = $("#select_taskhour").val().trim() + "-" + $("#select_taskminute").val().trim();
		var print_package = $("#select_taskpackage").find("option:selected").text().trim();
		var print_time = task_runtime.replace("-", "时 - ") + "分";
		if (flag) {
			request_task_add(task_name, task_package, task_module, task_level, task_runtime, print_time, print_package);
		} else {
			request_task_update(task_id, task_name, task_package, task_module, task_level, task_runtime, print_time, print_package);
		}
	});

	$(".task_hang").hover(function() {
		$(this).find("img").attr("src", $(this).find("img").attr("src").replace("disable", "enable"));
	}, function() {
		$(this).find("img").attr("src", $(this).find("img").attr("src").replace("enable", "disable"));
	});

	$(".task_hang").click(function() {
		var $parent = $(this).parent().parent().parent();
		var task_id = $parent.find("input[name=taskid]").val().trim();
		var task_hang = Math.abs(parseInt($parent.find("input[name=taskhang]").val().trim()) - 1);
		request_task_hang(task_id, task_hang);
	});

	$(".task_remove").hover(function() {
		$(this).find("img").attr("src", "/static/img/run/task_remove_enable.png");
	}, function() {
		$(this).find("img").attr("src", "/static/img/run/task_remove_disable.png");
	});

	$(".task_remove").click(function() {
		var $parent = $(this).parent().parent().parent();
		$("#input_delete_task_id").val($parent.find("input[name=taskid]").val().trim());
		global_board_show("delete_task", 1, 0);
	});

	$("#img_delete_task_close").click(function() {
		global_board_show("delete_task", 0, 0);
	});

	$("#img_delete_task_cancel").click(function() {
		global_board_show("delete_task", 0, 0);
	});

	$("#img_delete_task_ok").click(function() {
		var task_id = $("#input_delete_task_id").val().trim();
		request_task_delete(task_id);
	});

	$(".task_report_line").hover(function() {
		$(this).addClass("task_report_selected");
	}, function() {
		$(this).removeClass("task_report_selected");
	});

	$("#span_task_add").hover(function() {
		$(this).addClass("add_on");
	}, function() {
		$(this).removeClass("add_on");
	});

	$("#span_task_add").click(function() {
		global_form_reset(form_task_items);
		global_form_clear(form_task_items);
		$("#input_add_task_flag").val(1);
		$("#input_edit_task_id").val("");
		global_board_show("task", 1, 1);
	});
});