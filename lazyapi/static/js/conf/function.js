form_package_items = {
	name : {
		empty : 0,
		type : "input",
		name : "packagename",
		pass : "配置包名称，如：生产配置",
		fail : "请输入配置包名称"
	}
}

form_param_items = {
	keyword : {
		empty : 0,
		type : "input",
		name : "configkeyword",
		pass : "配置关键字，如：environment",
		fail : "请输入配置关键字"
	},
	value : {
		empty : 1,
		type : "input",
		name : "configvalue"
	}
}

form_data_items = {
	keyword : {
		empty : 0,
		type : "input",
		name : "configkeyword",
		pass : "配置关键字，如：environment",
		fail : "请输入配置关键字"
	},
	driver : {
		empty : 0,
		type : "select",
		name : "configdriver",
		def : ""
	},
	dsn : {
		empty : 0,
		type : "input",
		name : "configdsn",
		pass : "数据源连接串，如：server=myserver;database=mydb;user=admin;password=123456;charset=utf8",
		fail : "请输入数据源连接串"
	},
}

request_package_add = function(package_name) {
	$.ajax({
		url : "/index.php/api/package/add",
		type : "post",
		dataType : "json",
		data : {
			packagename : package_name
		},
		success : function(data) {
			if (data.code === "600011") {
				$("#input_packagename").val("");
				global_input_show("packagename", 0, "配置包 < " + package_name + " > 已存在");
				return;
			}
			var package_id = parseInt(data.message);
			if (!package_id) {
				global_board_show("package", -1, 0);
				return;
			}
			var $new_package = $(".package_tmp").clone(true);
			$new_package.removeClass("package_tmp").attr("id", "div_package_" + package_id);
			$new_package.find("input[name=packageid]").val(package_id);
			$new_package.find(".package_param").find("input[name=confignum]").val(0);
			$new_package.find(".package_data").find("input[name=confignum]").val(0);
			$new_package.find(".package_name").find("span").text(package_name);
			$("#div_package_loading").before($new_package);
			$("#div_package_loading").slideUp(100);
			global_board_show("package", -1, 1);
		},
		error : function(data) {
			global_board_show("package", -1, 0);
		}
	});
}

request_package_update = function(package_id, package_name) {
	$.ajax({
		url : "/index.php/api/package/update",
		type : "post",
		dataType : "json",
		data : {
			packageid : package_id,
			packagename : package_name
		},
		success : function(data) {
			if (data.code === "600012") {
				$("#input_packagename").val("");
				global_input_show("packagename", 0, "配置包 < " + package_name + " > 已存在");
				return;
			}
			$("#div_package_" + package_id).find(".package_name").find("span").text(package_name);
			global_board_show("package", -1, 1);
		},
		error : function(data) {
			global_board_show("package", -1, 0);
		}
	});
}

request_package_delete = function(package_id) {
	$.ajax({
		url : "/index.php/api/package/delete",
		type : "post",
		dataType : "json",
		data : {
			packageid : package_id
		},
		success : function(data) {
			$("#div_package_" + package_id).remove();
			global_board_show("delete_package", 0, 0);
		},
		error : function(data) {
			global_board_show("delete_package", 0, 0);
		}
	});
}

request_config_add = function(package_id, config_type, config_keyword, config_value) {
	$.ajax({
		url : "/index.php/api/conf/add",
		type : "post",
		dataType : "json",
		data : {
			packageid : package_id,
			configtype : config_type,
			configkeyword : config_keyword,
			configvalue : config_value
		},
		success : function(data) {
			if (data.code === "700011") {
				$("#input_configkeyword").val("");
				global_input_show("configkeyword", 0, "关键字 < " + config_keyword + " > 已存在");
				return;
			}
			if (data.code === "700022") {
				$("#input_configkeyword").val("");
				global_input_show("configkeyword", 0, "关键字只能由数字、字母和下划线组成");
				return;
			}
			var config_id = parseInt(data.message);
			if (!config_id) {
				global_board_show("config", -1, 0);
				return;
			}
			var $new_config = $(".config_tmp").clone(true);
			$new_config.removeClass("config_tmp").attr("id", "tr_config_" + config_id);
			$new_config.find("input[name=configid]").val(config_id);
			$new_config.find(".td_config_keyword").find("span").text(config_keyword);
			$new_config.find(".td_config_value").find("span").text(config_value);
			$("#tr_config_loading").before($new_config);
			$("#tr_config_loading").slideUp(100);
			global_board_show("config", -1, 1);
		},
		error : function(data) {
			global_board_show("module", -1, 0);
		}
	});
}

request_config_update = function(config_id, package_id, config_type, config_keyword, config_value) {
	$.ajax({
		url : "/index.php/api/conf/update",
		type : "post",
		dataType : "json",
		data : {
			configid : config_id,
			packageid : package_id,
			configtype : config_type,
			configkeyword : config_keyword,
			configvalue : config_value
		},
		success : function(data) {
			if (data.code === "700012") {
				$("#input_configkeyword").val("");
				global_input_show("configkeyword", 0, "关键字 < " + config_keyword + " > 已存在");
				return;
			}
			if (data.code === "700022") {
				$("#input_configkeyword").val("");
				global_input_show("configkeyword", 0, "关键字只能由数字、字母和下划线组成");
				return;
			}
			$("#tr_config_" + config_id).find("td[class=td_config_keyword]").attr("title", config_keyword).find("span").text(config_keyword);
			$("#tr_config_" + config_id).find("td[class=td_config_value]").attr("title", config_value).find("span").text(config_value);
			global_board_show("config", -1, 1);
		},
		error : function(data) {
			global_board_show("config", -1, 0);
		}
	});
}

request_config_delete = function(config_id) {
	$.ajax({
		url : "/index.php/api/conf/delete",
		type : "post",
		dataType : "json",
		data : {
			configid : config_id
		},
		success : function(data) {
			$("#tr_config_" + config_id).remove();
			global_board_show("delete_config", 0, 0);
		},
		error : function(data) {
			global_board_show("delete_config", 0, 0);
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
					return true;
				}
				var $new_package = $(".package_tmp").clone(true);
				$new_package.removeClass("package_tmp").attr("id", "div_package_" + obj.id);
				$new_package.find("input[name=packageid]").val(obj.id);
				$new_package.find(".package_param").find("input[name=confignum]").val(obj.config_num.param);
				$new_package.find(".package_data").find("input[name=confignum]").val(obj.config_num.data);
				$new_package.find(".package_name").find("span").text(obj.name);
				$("#div_package_loading").before($new_package);
			});
			$("#div_package_loading").slideUp(100);
		},
		error : function(data) {

		}
	});
}

load_config_list = function(package_id, type, page, size) {
	$.ajax({
		url : "/index.php/api/conf/list",
		type : "post",
		dataType : "json",
		data : {
			packageid : package_id,
			type : type,
			page : page,
			size : size
		},
		success : function(data) {
			if (!data.length) {
				$("#tr_config_loading").find("img").hide();
				$("#tr_config_loading").find("span").text("暂无配置");
				return;
			}
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return true;
				}
				var $new_config = $(".config_tmp").clone(true);
				$new_config.removeClass("config_tmp").attr("id", "tr_config_" + obj.id);
				$new_config.find("input[name=configid]").val(obj.id);
				$new_config.find("td[class=td_config_keyword]").attr("title", obj.keyword).find("span").text(obj.keyword);
				$new_config.find("td[class=td_config_value]").attr("title", obj.value).find("span").text(obj.value);
				$("#tr_config_loading").before($new_config);
			});
			$("#tr_config_loading").slideUp(100);
		},
		error : function(data) {

		}
	});
}

public_page_recall = function(page) {
	$(".config_line:not(.config_tmp)").remove();
	$("#tr_config_loading").show();
	var package_id = $(".package_selected").find("input[name=packageid]").val().trim();
	var type = $(".package_tree_selected").find("input[name=type]").val().trim();
	load_config_list(package_id, type, page, 10);
}