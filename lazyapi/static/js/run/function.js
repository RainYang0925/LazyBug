form_task_items = {
	name : {
		empty : 0,
		type : "input",
		name : "taskname",
		pass : "任务名称，如：用户接口每日回归",
		fail : "请输入任务名称"
	},
	pkg : {
		empty : 0,
		type : "select",
		name : "taskpackage",
		def : "0"
	},
	module : {
		empty : 0,
		type : "select",
		name : "taskmodule",
		def : "0"
	},
	level : {
		empty : 0,
		type : "select",
		name : "tasklevel",
		def : "3"
	},
	hour : {
		empty : 0,
		type : "select",
		name : "taskhour",
		def : "/"
	},
	minute : {
		empty : 0,
		type : "select",
		name : "taskminute",
		def : "/"
	}
}

request_task_list = function(page, size, history_size) {
	$.ajax({
		url : "/index.php/api/task/list",
		type : "post",
		dataType : "json",
		data : {
			page : page,
			size : size,
			historysize : history_size
		},
		success : function(data) {
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return true;
				}
				if (obj.running) {
					$("#div_task_" + obj.id).find(".task_name").find("img").attr("src", "/static/img/run/running.gif");
					$("#div_task_" + obj.id).find(".task_run").find("img").attr("src", "/static/img/run/task_stop_enable.png");
					$("#div_task_" + obj.id).find(".task_run").find("img").attr("title", "停止测试");
					if (obj.total) {
						var rate = parseInt(obj.current * 100 / obj.total);
						$("#div_task_" + obj.id).find(".task_loading").find("div").width(rate + "%");
					}
					$("#div_task_" + obj.id).find(".task_process").show();
				} else {
					$("#div_task_" + obj.id).find(".task_name").find("img").attr("src", "/static/img/run/clock.png");
					$("#div_task_" + obj.id).find(".task_run").find("img").attr("src", "/static/img/run/task_run_enable.png");
					$("#div_task_" + obj.id).find(".task_run").find("img").attr("title", "运行测试");
					$("#div_task_" + obj.id).find(".task_process").hide();
				}
			});
		},
		error : function(data) {

		}
	});
}

request_task_add = function(task_name, task_package, task_module, task_level, task_runtime, print_time, print_package) {
	$.ajax({
		url : "/index.php/api/task/add",
		type : "post",
		dataType : "json",
		data : {
			taskname : task_name,
			taskpackage : task_package,
			taskmodule : task_module,
			tasklevel : task_level,
			taskruntime : task_runtime
		},
		success : function(data) {
			if (data.code === "800011") {
				$("#input_taskname").val("");
				global_input_show("taskname", 0, "任务名称 < " + task_name + " > 已存在");
				return;
			}
			var task_id = parseInt(data.message);
			if (!task_id) {
				global_board_show("task", -1, 0);
				return;
			}
			var $new_task = $(".task_tmp").clone(true);
			$new_task.removeClass("task_tmp").attr("id", "div_task_" + task_id);
			$new_task.find("input[name=taskid]").val(task_id);
			$new_task.find("input[name=packageid]").val(task_package);
			$new_task.find("input[name=moduleid]").val(task_module);
			$new_task.find("input[name=tasklevel]").val(task_level);
			$new_task.find("input[name=taskruntime]").val(task_runtime);
			$new_task.find("input[name=taskhang]").val(0);
			$new_task.find(".task_name").find("span").text(task_name);
			$new_task.find(".print_time").html(print_time);
			$new_task.find(".print_package").html(print_package);
			$("#div_task_loading").before($new_task);
			$("#div_task_loading").slideUp(100);
			global_board_show("task", -1, 1);
		},
		error : function(data) {
			global_board_show("task", -1, 0);
		}
	});
}

request_task_hang = function(task_id, task_hang) {
	$.ajax({
		url : "/index.php/api/task/hang",
		type : "post",
		dataType : "json",
		data : {
			taskid : task_id,
			taskhang : task_hang
		},
		success : function(data) {
			if (task_hang) {
				$("#div_task_" + task_id).find("input[name=taskhang]").val(task_hang);
				$("#div_task_" + task_id).addClass("task_locked");
				$("#div_task_" + task_id).find(".task_hang").find("img").attr("src", "/static/img/run/task_locked_enable.png");
			} else {
				$("#div_task_" + task_id).find("input[name=taskhang]").val(task_hang);
				$("#div_task_" + task_id).removeClass("task_locked");
				$("#div_task_" + task_id).find(".task_hang").find("img").attr("src", "/static/img/run/task_unlock_enable.png");
			}
		},
		error : function(data) {

		}
	});
}

request_task_update = function(task_id, task_name, task_package, task_module, task_level, task_runtime, print_time, print_package) {
	$.ajax({
		url : "/index.php/api/task/update",
		type : "post",
		dataType : "json",
		data : {
			taskid : task_id,
			taskname : task_name,
			taskpackage : task_package,
			taskmodule : task_module,
			tasklevel : task_level,
			taskruntime : task_runtime
		},
		success : function(data) {
			if (data.code === "800012") {
				$("#input_taskname").val("");
				global_input_show("taskname", 0, "任务名称 < " + task_name + " > 已存在");
				return;
			}
			$("#div_task_" + task_id).find("input[name=packageid]").val(task_package);
			$("#div_task_" + task_id).find("input[name=moduleid]").val(task_module);
			$("#div_task_" + task_id).find("input[name=tasklevel]").val(task_level);
			$("#div_task_" + task_id).find("input[name=taskruntime]").val(task_runtime);
			$("#div_task_" + task_id).find(".task_name").find("span").text(task_name);
			$("#div_task_" + task_id).find(".print_time").text(print_time);
			$("#div_task_" + task_id).find(".print_package").text(print_package);
			global_board_show("task", -1, 1);
		},
		error : function(data) {
			global_board_show("task", -1, 0);
		}
	});
}

request_task_delete = function(task_id) {
	$.ajax({
		url : "/index.php/api/task/delete",
		type : "post",
		dataType : "json",
		data : {
			taskid : task_id
		},
		success : function(data) {
			$("#div_task_" + task_id).remove();
			global_board_show("delete_task", 0, 0);
		},
		error : function(data) {
			global_board_show("delete_task", 0, 0);
		}
	});
}

request_job_add = function(task_id) {
	$.ajax({
		url : "/index.php/api/job/add",
		type : "post",
		dataType : "json",
		data : {
			taskid : task_id
		},
		success : function(data) {
			if (data.code !== "000000" && data.code !== "900011") {
				return;
			}
			$("#div_task_" + task_id).addClass("task_running");
			$("#div_task_" + task_id).find(".task_name").find("img").attr("src", "/static/img/run/running.gif");
			$("#div_task_" + task_id).find(".task_run").find("img").attr("src", "/static/img/run/task_stop_enable.png");
			$("#div_task_" + task_id).find(".task_run").find("img").attr("title", "停止测试");
			$("#div_task_" + task_id).find(".task_loading").find("div").width("1%");
			$("#div_task_" + task_id).find(".task_process").show();
		},
		error : function(data) {

		}
	});
}

request_job_delete = function(task_id) {
	$.ajax({
		url : "/index.php/api/job/delete",
		type : "post",
		dataType : "json",
		data : {
			taskid : task_id
		},
		success : function(data) {
			if (data.code !== "000000") {
				return;
			}
			$("#div_task_" + task_id).removeClass("task_running");
			$("#div_task_" + task_id).find(".task_name").find("img").attr("src", "/static/img/run/clock.png");
			$("#div_task_" + task_id).find(".task_run").find("img").attr("src", "/static/img/run/task_run_enable.png");
			$("#div_task_" + task_id).find(".task_run").find("img").attr("title", "运行测试");
			$("#div_task_" + task_id).find(".task_process").hide();
		},
		error : function(data) {

		}
	});
}

load_task_list = function(page, size, history_size) {
	$.ajax({
		url : "/index.php/api/task/list",
		type : "post",
		dataType : "json",
		data : {
			page : page,
			size : size,
			historysize : history_size
		},
		success : function(data) {
			if (!data.length) {
				$("#div_task_loading").find("img").hide();
				$("#div_task_loading").find("#span_task_text").text("当前任务列表为空，点击\"+\"添加新任务");
				$("#div_task_loading").find("#span_task_add").show();
				return;
			}
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return true;
				}
				var $new_task = $(".task_tmp").clone(true);
				var print_package = obj.packagename ? obj.packagename : "预设配置";
				var print_time = obj.runtime.replace("-", "时 - ") + "分";
				$new_task.removeClass("task_tmp").attr("id", "div_task_" + obj.id);
				$new_task.find("input[name=taskid]").val(obj.id);
				$new_task.find("input[name=packageid]").val(obj.package_id);
				$new_task.find("input[name=moduleid]").val(obj.module_id);
				$new_task.find("input[name=tasklevel]").val(obj.level);
				$new_task.find("input[name=taskruntime]").val(obj.runtime);
				$new_task.find("input[name=taskhang]").val(obj.hang);
				$new_task.find(".task_name").find("span").text(obj.name);
				$new_task.find(".print_time").text(print_time);
				$new_task.find(".print_package").text(print_package);
				if (obj.hang === "1") {
					$new_task.addClass("task_locked");
					$new_task.find(".task_hang").find("img").attr("src", "/static/img/run/task_locked_disable.png");
					$new_task.find(".task_hang").find("img").attr("title", "启用");
				} else {
					$new_task.find(".task_hang").find("img").attr("src", "/static/img/run/task_unlock_disable.png");
					$new_task.find(".task_hang").find("img").attr("title", "禁用");
				}
				if (obj.running) {
					$new_task.addClass("task_running");
					$new_task.find(".task_name").find("img").attr("src", "/static/img/run/running.gif");
					$new_task.find(".task_run").find("img").attr("src", "/static/img/run/task_stop_disable.png");
					$new_task.find(".task_run").find("img").attr("title", "停止测试");
					if (obj.total) {
						var rate = parseInt(obj.current * 100 / obj.total);
						$new_task.find(".task_loading").find("div").width(rate + "%");
					}
					$new_task.find(".task_process").show();
				}
				if (obj.history.length) {
					$.each(obj.history, function(index, obj) {
						var $new_report = $new_task.find(".task_report_tmp").clone(true);
						$new_report.removeClass("task_report_tmp").attr("id", "div_task_report_" + obj.id);
						$new_report.find(".task_report_detail").find("span").text(obj.runtime + " 检查点通过 : " + obj.pass + " 失败 : " + obj.fail);
						$new_report.find(".task_report_opt").find("a").attr("href", "/index.php/report?id=" + obj.id);
						$new_task.find(".no_report").before($new_report);
					});
				} else {
					$new_task.find(".no_report").show();
				}
				$("#div_task_loading").before($new_task);
			});
			$("#div_task_loading").slideUp(100);
		},
		error : function(data) {

		}
	});
}

load_package_list = function() {
	$.ajax({
		url : "/index.php/api/package/list",
		type : "post",
		dataType : "json",
		data : {},
		success : function(data) {
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return;
				}
				$("#select_taskpackage").append("<option value=\"" + obj.id + "\">" + obj.name + "</option>");
			});
		},
		error : function(data) {

		}
	});
}

load_module_list = function() {
	$.ajax({
		url : "/index.php/api/module/list",
		type : "post",
		dataType : "json",
		data : {},
		success : function(data) {
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return;
				}
				$("#select_taskmodule").append("<option value=\"" + obj.id + "\">" + obj.name + "</option>");
			});
		},
		error : function(data) {

		}
	});
}

sync_task_status = function() {
	var page = parseInt($(".global_page_current").text());
	request_task_list(page, 10, 3);
	setTimeout("sync_task_status()", 5000);
}

public_page_recall = function(page) {
	$(".task_line:not(.task_tmp)").remove();
	$("#div_task_loading").show();
	load_task_list(page, 20, 3);
}