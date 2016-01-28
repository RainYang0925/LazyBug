form_check_items = {
	name : {
		empty : 0,
		type : "input",
		name : "checkname",
		pass : "步骤名称，如：检查用户状态",
		fail : "请输入步骤名称"
	},
	all : {
		type : "checkbox",
		name : "checkall",
	},
	begin : {
		type : "checkbox",
		name : "checkbegin",
	},
	end : {
		type : "checkbox",
		name : "checkend",
	},
	reg : {
		type : "checkbox",
		name : "checkreg",
	},
	value : {
		empty : 0,
		type : "input",
		name : "checkvalue",
		pass : "校验内容，如：\"status\":1",
		fail : "请输入校验内容"
	}
}

form_call_items = {
	name : {
		empty : 0,
		type : "input",
		name : "callname",
		pass : "步骤名称，如：调用用户登录接口",
		fail : "请输入步骤名称"
	},
	icase : {
		empty : 0,
		type : "select",
		name : "callcase",
		def : ""
	}
}

form_store_items = {
	name : {
		empty : 0,
		type : "input",
		name : "storename",
		pass : "步骤名称，如：查询用户信息",
		fail : "请输入步骤名称"
	},
	config : {
		empty : 0,
		type : "input",
		name : "storeconfig",
		pass : "数据配置，如：localdb",
		fail : "请输入数据配置"
	},
	value : {
		empty : 0,
		type : "input",
		name : "storevalue",
		pass : "查询内容，如：select * from user where userid=1",
		fail : "请输入查询内容"
	}
}

form_option_items = {
	icase : {
		empty : 0,
		type : "select",
		name : "optionpackage",
		def : ""
	}
}

request_step_info = function(case_id) {
	$.ajax({
		url : "/index.php/api/step/info",
		type : "post",
		dataType : "json",
		data : {
			caseid : case_id
		},
		success : function(data) {
			$.each(data, function(index, obj) {
				if (!obj.type) {
					return true;
				}
				if (obj.type === "接口调用" && obj.command === "self") {
					$new_step = $("#div_step_0").clone(true);
					$("#div_step_0").remove();
					$(".step_tmp").before($new_step);
					return;
				}
				switch (obj.type) {
				case "检查点":
					var img_name = "check";
					break;
				case "接口调用":
					var img_name = "call";
					break;
				case "存储查询":
					var img_name = "store";
					break;
				default:
					var img_name = "check";
				}
				var $new_step = $(".step_tmp").clone(true);
				$new_step.removeClass("step_tmp").attr("id", "div_step_" + step_line_id++);
				$new_step.find(".step_type").find("img").attr("src", "/static/img/sort/step_" + img_name + ".png");
				$new_step.find(".step_type").find("span").text(obj.type);
				$new_step.find("input[name=stepcommand]").val(obj.command);
				$new_step.find("input[name=stepvalue]").val(obj.value);
				$new_step.find(".step_name").find("span").text(obj.name);
				$new_step.show();
				$(".step_tmp").before($new_step);
			});
			setTimeout(function() {
				global_board_show("reload", 0, 0);
			}, 500);
		},
		error : function(data) {
			setTimeout(function() {
				global_board_show("reload", 0, 0);
			}, 500);
		}
	});
}

request_step_save = function(case_id) {
	$.ajax({
		url : "/index.php/api/step/delete",
		type : "post",
		dataType : "json",
		data : {
			caseid : case_id
		},
		success : function(data) {
			$.each($(".step_line:not(.step_tmp)"), function(i) {
				var step_name = $(this).find(".step_name").find("span").text();
				var step_type = $(this).find(".step_type").find("span").text();
				var step_command = $(this).find("input[name=stepcommand]").val();
				var step_value = $(this).find("input[name=stepvalue]").val();
				request_step_add(case_id, step_name, step_type, step_command, step_value, i + 1);
			});
			change_status(1);
		},
		error : function(data) {
			change_status(0);
		}
	});
}

request_step_add = function(case_id, step_name, step_type, step_command, step_value, step_sequence) {
	$.ajax({
		url : "/index.php/api/step/add",
		type : "post",
		dataType : "json",
		data : {
			caseid : case_id,
			stepname : step_name,
			steptype : step_type,
			stepcommand : step_command,
			stepvalue : step_value,
			stepsequence : step_sequence
		},
		success : function(data) {

		},
		error : function(data) {

		}
	});
}

load_module_list = function() {
	$("#select_callmodule").empty();
	$("#select_callitem").empty();
	$("#select_callcase").empty();
	$("#select_callmodule").append(get_option("", "请选择一个模块..."));
	$("#select_callmodule").append(get_option("0", "全部模块"));
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
				$("#select_callmodule").append(get_option(obj.id, obj.name));
			});
		},
		error : function(data) {

		}
	});
}

load_item_list = function(module_id) {
	$("#select_callitem").empty();
	$("#select_callcase").empty();
	$("#select_callitem").append(get_option("", "请选择一个接口..."));
	$.ajax({
		url : "/index.php/api/item/list",
		type : "post",
		dataType : "json",
		data : {
			moduleid : module_id,
			page : 0,
			size : 0,
		},
		success : function(data) {
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return;
				}
				$("#select_callitem").append(get_option(obj.id, obj.name));
			});
		},
		error : function(data) {

		}
	});
}

load_case_list = function(item_id) {
	$("#select_callcase").empty();
	$("#select_callcase").append(get_option("", "请选择一个用例..."));
	$.ajax({
		url : "/index.php/api/case/list",
		type : "post",
		dataType : "json",
		data : {
			itemid : item_id,
		},
		success : function(data) {
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return;
				}
				$("#select_callcase").append(get_option(obj.id, obj.name));
			});
		},
		error : function(data) {

		}
	});
}

load_package_list = function() {
	$("#select_optionpackage").empty();
	$("#select_optionpackage").append(get_option("0", "预设配置"));
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
				$("#select_optionpackage").append(get_option(obj.id, obj.name));
			});
		},
		error : function(data) {

		}
	});
}

run_step = function(current, package_id, result) {
	var $step_list = $(".step_line:not(.step_tmp)");
	if (current >= $step_list.length) {
		change_status(1);
		return;
	}
	var $step = $step_list.eq(current);
	var step_type = $step.find(".step_type").find("span").text();
	var step_command = $step.find("input[name=stepcommand]").val();
	var step_value = $step.find("input[name=stepvalue]").val();
	$step.find(".run_sign").show();
	if (step_type === "检查点") {
		$.ajax({
			url : "/index.php/api/server/check",
			type : "post",
			dataType : "text",
			data : {
				temp : 1,
				result : result,
				command : step_command,
				value : step_value
			},
			success : function(data) {
				$step.find(".run_sign").delay(1000).hide(0, function() {
					add_result($step, data);
					run_step(current + 1, package_id, result);
				});
			},
			error : function(data) {
				$step.find(".run_sign").delay(1000).hide(0, function() {
					add_result($step, data);
					run_step(current + 1, package_id, result);
				});
			}
		});
	} else if (step_type === "接口调用") {
		$.ajax({
			url : "/index.php/api/server/call",
			type : "post",
			dataType : "text",
			data : {
				temp : 1,
				extend : result,
				callid : step_value,
				packageid : package_id
			},
			success : function(data) {
				result = data;
				$step.find(".run_sign").delay(1000).hide(0, function() {
					add_result($step, data);
					run_step(current + 1, package_id, result);
				});
			},
			error : function(data) {
				$step.find(".run_sign").delay(1000).hide(0, function() {
					add_result($step, data);
					run_step(current + 1, package_id, result);
				});
			}
		});
	} else if (step_type === "存储查询") {
		$.ajax({
			url : "/index.php/api/server/store",
			type : "post",
			dataType : "text",
			data : {
				temp : 1,
				command : step_command,
				value : step_value,
				packageid : package_id
			},
			success : function(data) {
				result = data;
				$step.find(".run_sign").delay(1000).hide(0, function() {
					add_result($step, data);
					run_step(current + 1, package_id, result);
				});
			},
			error : function(data) {
				$step.find(".run_sign").delay(1000).hide(0, function() {
					add_result($step, data);
					run_step(current + 1, package_id, result);
				});
			}
		});
	}
}

get_check_option = function() {
	var command = "include";
	if ($("#checkbox_checkall").prop("checked")) {
		command = "all";
	}
	if ($("#checkbox_checkbegin").prop("checked")) {
		command += " | begin";
	}
	if ($("#checkbox_checkend").prop("checked")) {
		command += " | end";
	}
	if ($("#checkbox_checkreg").prop("checked")) {
		command += " | reg";
	}
	return command;
}

set_check_option = function() {
	var command = $("#input_checkcommand").val().trim().split("|");
	$.each(command, function(i) {
		command[i] = this.toString().trim();
	});
	$("#checkbox_checkall").prop("checked", command.indexOf("all") === -1 ? false : true);
	$("#checkbox_checkbegin").prop("checked", command.indexOf("begin") === -1 ? false : true);
	$("#checkbox_checkend").prop("checked", command.indexOf("end") === -1 ? false : true);
	$("#checkbox_checkreg").prop("checked", command.indexOf("reg") === -1 ? false : true);
}

add_result = function($parent, data) {
	$new_result = $(".result_tmp").clone(true);
	$new_result.removeClass("result_tmp");
	$new_result.find("span").text(data);
	$new_result.show();
	$parent.append($new_result);
}

get_option = function(key, value) {
	if (key != "") {
		return "<option value=\"" + key + "\">" + value + "</option>";
	}
	return "<option value=\"" + key + "\" disabled=\"disabled\" selected=\"selected\">" + value + "</option>";
}

change_status = function(status) {
	if (status) {
		$("#div_save").hide();
		if (status == -1) {
			$("#div_saved").hide();
			$("#div_run").hide();
			$("#div_clear").hide();
			$("#div_loading").show();
		} else {
			$("#div_loading").delay(300).hide(0, function() {
				$("#div_saved").show();
				$("#div_run").show();
				$("#div_clear").show();
			});
		}
	} else {
		$("#div_loading").hide();
		if ($("#div_save").length > 0) {
			$("#div_run").hide();
			$("#div_saved").hide();
			$("#div_save").show();
		}
	}
}