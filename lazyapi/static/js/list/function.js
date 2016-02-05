form_module_items = {
	name : {
		empty : 0,
		type : "input",
		name : "modulename",
		pass : "模块名称，如：用户中心",
		fail : "请输入模块名称"
	}
}

form_item_items = {
	name : {
		empty : 0,
		type : "input",
		name : "itemname",
		pass : "接口名称，如：用户登录",
		fail : "请输入接口名称"
	},
	url : {
		empty : 0,
		type : "input",
		name : "itemurl",
		pass : "接口请求地址，如：http://www.lazybug.cn/api/demo",
		fail : "请输入接口请求地址"
	}
}

form_case_items = {
	name : {
		empty : 0,
		type : "input",
		name : "casename",
		pass : "用例名称，如：使用正确帐号登录",
		fail : "请输入用例名称"
	},
	type : {
		empty : 0,
		type : "select",
		name : "sendtype",
		def : "GET"
	},
	type : {
		empty : 0,
		type : "select",
		name : "contenttype",
		def : "application/x-www-form-urlencoded"
	},
	param : {
		empty : 1,
		type : "input",
		name : "requestparam"
	},
	header : {
		empty : 1,
		type : "input",
		name : "responseheader"
	}
}

register_module_droppable = function(event, ui) {
	var item_id = ui.helper.find("input[name=itemid]").val().trim();
	var module_id = $(this).find("input[name=moduleid]").val().trim();
	var source_id = ui.helper.find("input[name=moduleid]").val().trim();
	request_item_switch(item_id, module_id, source_id);
}

request_module_count = function(module_id) {
	var $parent = $("input[name=moduleid][value=" + module_id + "]").parent().parent().parent();
	$parent.find(".count_num_item").html("<img src=\"/static/img/list/load.gif\" />");
	$parent.find(".count_num_case").html("<img src=\"/static/img/list/load.gif\" />");
	$.ajax({
		url : "/index.php/api/module/count",
		type : "post",
		dataType : "json",
		data : {
			moduleid : module_id
		},
		success : function(data) {
			$parent.find("input[name=itemnum]").val(parseInt(data.item_num.count));
			$parent.find(".count_num_item").text(parseInt(data.item_num.count));
			$parent.find(".count_num_case").text(parseInt(data.case_num.count));
		},
		error : function(data) {
			$parent.find("input[name=itemnum]").val(0);
			$parent.find(".count_num_item").text(0);
			$parent.find(".count_num_case").text(0);
		}
	});
}

request_module_add = function(module_name) {
	$.ajax({
		url : "/index.php/api/module/add",
		type : "post",
		dataType : "json",
		data : {
			modulename : module_name
		},
		success : function(data) {
			if (data.code === "200011") {
				$("#input_modulename").val("");
				global_input_show("modulename", 0, "模块 < " + module_name + " > 已存在");
				return;
			}
			var module_id = parseInt(data.message);
			if (!module_id) {
				global_board_show("module", -1, 0);
				return;
			}
			var $new_module = $(".module_tmp").clone(true);
			$new_module.removeClass("module_tmp").attr("id", "div_module_" + module_id);
			$new_module.find(".module_tag").addClass("module_tag_new");
			$new_module.find("input[name=moduleid]").val(module_id);
			$new_module.find("input[name=itemnum]").val(0);
			$new_module.find(".module_name").find("span").text(module_name);
			$new_module.find(".module_count").find(".count_num_item").text(0);
			$new_module.find(".module_count").find(".count_num_case").text(0);
			$new_module.droppable({
				accept : '.item_drag',
				drop : register_module_droppable
			});
			$("#div_module_loading").before($new_module);
			$("#div_module_loading").slideUp(100);
			global_board_show("module", -1, 1);
		},
		error : function(data) {
			global_board_show("module", -1, 0);
		}
	});
}

request_module_update = function(module_id, module_name) {
	$.ajax({
		url : "/index.php/api/module/update",
		type : "post",
		dataType : "json",
		data : {
			moduleid : module_id,
			modulename : module_name
		},
		success : function(data) {
			if (data.code === "200012") {
				$("#input_modulename").val("");
				global_input_show("modulename", 0, "模块 < " + module_name + " > 已存在");
				return;
			}
			$("#div_module_" + module_id).find(".module_name").find("span").text(module_name);
			global_board_show("module", -1, 1);
		},
		error : function(data) {
			global_board_show("module", -1, 0);
		}
	});
}

request_module_delete = function(module_id) {
	$.ajax({
		url : "/index.php/api/module/delete",
		type : "post",
		dataType : "json",
		data : {
			moduleid : module_id
		},
		success : function(data) {
			$("#div_module_" + module_id).remove();
			global_board_show("delete_module", 0, 0);
		},
		error : function(data) {
			global_board_show("delete_module", 0, 0);
		}
	});
}

request_item_switch = function(item_id, module_id, source_id) {
	$.ajax({
		url : "/index.php/api/item/switch",
		type : "post",
		dataType : "json",
		data : {
			itemid : item_id,
			moduleid : module_id
		},
		success : function(data) {
			var current_id = parseInt($(".module_selected").find("input[name=moduleid]").val().trim());
			source_id = parseInt(source_id);
			module_id = parseInt(module_id);
			if (current_id) {
				$("#tr_item_" + item_id).remove();
				$("#tr_item_case_" + item_id).remove();
			} else {
				$("#tr_item_" + item_id).find("input[name=moduleid]").val(module_id);
			}
			source_id && request_module_count(source_id);
			module_id != source_id && module_id && request_module_count(module_id);
		},
		error : function(data) {

		}
	});
}

request_item_add = function(module_id, item_name, item_url) {
	$.ajax({
		url : "/index.php/api/item/add",
		type : "post",
		dataType : "json",
		data : {
			moduleid : module_id,
			itemname : item_name,
			itemurl : item_url
		},
		success : function(data) {
			if (data.code === "300011") {
				$("#input_itemname").val("");
				global_input_show("itemname", 0, "接口 < " + item_name + " > 已存在");
				return;
			}
			var item_id = parseInt(data.message);
			if (!item_id) {
				global_board_show("item", -1, 0);
				return;
			}
			request_module_count(0);
			module_id && request_module_count(module_id);
			var $new_item = $(".item_tmp").clone(true);
			$new_item.removeClass("item_tmp").attr("id", "tr_item_" + item_id);
			$new_item.find("input[name=itemid]").val(item_id);
			$new_item.find("input[name=moduleid]").val(module_id);
			$new_item.find("input[name=itemurl]").val(item_url);
			$new_item.find("td[class=td_item_name]").attr("title", item_name).find("span").text(item_name);
			$new_item.find(".item_drag").draggable({
				containment : "window",
				handle : "img",
				helper : "clone",
				revert : "invalid",
			});
			$("#tr_item_loading").before($new_item);
			$("#tr_item_loading").slideUp(100);
			global_board_show("item", -1, 1);
		},
		error : function(data) {
			global_board_show("item", -1, 0);
		}
	});
}

request_item_update = function(item_id, item_name, item_url) {
	$.ajax({
		url : "/index.php/api/item/update",
		type : "post",
		dataType : "json",
		data : {
			itemid : item_id,
			itemname : item_name,
			itemurl : item_url
		},
		success : function(data) {
			if (data.code === "300012") {
				$("#input_itemname").val("");
				global_input_show("itemname", 0, "接口 < " + item_name + " > 已存在");
				return;
			}
			$("#tr_item_" + item_id).find("input[name=itemurl]").val(item_url);
			$("#tr_item_" + item_id).find("td[class=td_item_name]").attr("title", item_name).find("span").text(item_name);
			global_board_show("item", -1, 1);
		},
		error : function(data) {
			global_board_show("item", -1, 0);
		}
	});
}

request_item_delete = function(item_id) {
	$.ajax({
		url : "/index.php/api/item/delete",
		type : "post",
		dataType : "json",
		data : {
			itemid : item_id
		},
		success : function(data) {
			var module_id = parseInt($("#tr_item_" + item_id).find("input[name=moduleid]").val().trim());
			request_module_count(0);
			module_id && request_module_count(module_id);
			$("#tr_item_" + item_id).remove();
			$("#tr_item_case_" + item_id).remove();
			global_board_show("delete_item", 0, 0);
		},
		error : function(data) {
			global_board_show("delete_item", 0, 0);
		}
	});
}

request_case_add = function(item_id, module_id, case_name, send_type, content_type, request_param, response_header) {
	$.ajax({
		url : "/index.php/api/case/add",
		type : "post",
		dataType : "json",
		data : {
			itemid : item_id,
			moduleid : module_id,
			casename : case_name,
			sendtype : send_type,
			contenttype : content_type,
			requestparam : request_param,
			responseheader : response_header
		},
		success : function(data) {
			if (data.code === "400011") {
				$("#input_casename").val("");
				global_input_show("casename", 0, "用例 < " + case_name + " > 已存在");
				return;
			}
			var case_id = parseInt(data.message);
			if (!case_id) {
				global_board_show("case", -1, 0);
				return;
			}
			request_module_count(0);
			module_id && request_module_count(module_id);
			var $parent = $("#tr_item_" + item_id).next(".item_case_line");
			var $new_case = $parent.find(".case_tmp").clone(true);
			$new_case.removeClass("case_tmp").attr("id", "tr_case_" + case_id);
			$new_case.find(".level_icon").attr("title", "").attr("src", "/static/img/list/level_" + 3 + ".jpg");
			$new_case.find("input[name=caseid]").val(case_id);
			$new_case.find("input[name=casename]").val(case_name);
			$new_case.find("input[name=sendtype]").val(send_type);
			$new_case.find("input[name=contenttype]").val(content_type);
			$new_case.find("input[name=requestparam]").val(request_param);
			$new_case.find("input[name=caselevel]").val(3);
			$new_case.find("textarea[name=responseheader]").val(response_header);
			$new_case.find("td[class=td_case_id]").attr("title", case_name).find("span").text("Case-" + case_id + "  :  " + case_name);
			$parent.find(".case_loading").before($new_case);
			$parent.find(".case_loading").slideUp(100);
			global_board_show("case", -1, 1);
		},
		error : function(data) {
			global_board_show("case", -1, 0);
		}
	});
}

request_case_level = function(case_id, case_level) {
	$.ajax({
		url : "/index.php/api/case/level",
		type : "post",
		dataType : "json",
		data : {
			caseid : case_id,
			caselevel : case_level
		},
		success : function(data) {
			$("#tr_case_" + case_id).find(".level_icon").attr("src", "/static/img/list/level_" + case_level + ".jpg");
			$("#tr_case_" + case_id).find("input[name=caselevel]").val(case_level);
			global_board_show("case_level", 0, 0);
		},
		error : function(data) {
			global_board_show("case_level", 0, 0);
		}
	});
}

request_case_update = function(case_id, case_name, send_type, content_type, request_param, response_header) {
	$.ajax({
		url : "/index.php/api/case/update",
		type : "post",
		dataType : "json",
		data : {
			caseid : case_id,
			casename : case_name,
			sendtype : send_type,
			contenttype : content_type,
			requestparam : request_param,
			responseheader : response_header
		},
		success : function(data) {
			if (data.code === "400012") {
				$("#input_casename").val("");
				global_input_show("casename", 0, "用例 < " + case_name + " > 已存在");
				return;
			}
			$("#tr_case_" + case_id).find("input[name=casename]").val(case_name);
			$("#tr_case_" + case_id).find("input[name=sendtype]").val(send_type);
			$("#tr_case_" + case_id).find("input[name=contenttype]").val(content_type);
			$("#tr_case_" + case_id).find("input[name=requestparam]").val(request_param);
			$("#tr_case_" + case_id).find("textarea[name=responseheader]").val(response_header);
			$("#tr_case_" + case_id).find("td[class=td_case_id]").attr("title", case_name).find("span").text("Case-" + case_id + "  :  " + case_name);
			global_board_show("case", -1, 1);
		},
		error : function(data) {
			global_board_show("case", -1, 0);
		}
	});
}

request_case_delete = function(case_id) {
	$.ajax({
		url : "/index.php/api/case/delete",
		type : "post",
		dataType : "json",
		data : {
			caseid : case_id
		},
		success : function(data) {
			var $parent = $("#tr_case_" + case_id).parent().parent().parent().parent();
			var module_id = parseInt($parent.prev(".item_line").find("input[name=moduleid]").val().trim());
			request_module_count(0);
			module_id && request_module_count(module_id);
			$("#tr_case_" + case_id).remove();
			global_board_show("delete_case", 0, 0);
		},
		error : function(data) {
			global_board_show("delete_case", 0, 0);
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
					return true;
				}
				var $new_module = $(".module_tmp").clone(true);
				$new_module.removeClass("module_tmp").attr("id", "div_module_" + obj.id);
				$new_module.find(".module_tag").addClass("module_tag_" + ((index + 1) % 4 + 1));
				$new_module.find("input[name=moduleid]").val(obj.id);
				$new_module.find("input[name=itemnum]").val(obj.item_num);
				$new_module.find(".module_name").find("span").text(obj.name);
				$new_module.find(".module_count").find(".count_num_item").text(obj.item_num);
				$new_module.find(".module_count").find(".count_num_case").text(obj.case_num);
				$new_module.droppable({
					accept : '.item_drag',
					drop : register_module_droppable
				});
				$("#div_module_loading").before($new_module);
			});
			$("#div_module_loading").slideUp(100);
		},
		error : function(data) {

		}
	});
}

load_item_list = function(module_id, page, size) {
	$.ajax({
		url : "/index.php/api/item/list",
		type : "post",
		dataType : "json",
		data : {
			moduleid : module_id,
			page : page,
			size : size
		},
		success : function(data) {
			if (!data.length) {
				$("#tr_item_loading").find("img").hide();
				$("#tr_item_loading").find("span").text("暂无接口");
				return;
			}
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return true;
				}
				var $new_item = $(".item_tmp").clone(true);
				$new_item.removeClass("item_tmp").attr("id", "tr_item_" + obj.id);
				$new_item.find("input[name=itemid]").val(obj.id);
				$new_item.find("input[name=moduleid]").val(obj.module_id);
				$new_item.find("input[name=itemurl]").val(obj.url);
				$new_item.find("td[class=td_item_name]").attr("title", obj.name).find("span").text(obj.name);
				$new_item.find(".item_drag").draggable({
					containment : "window",
					handle : "img",
					helper : "clone",
					revert : "invalid",
				});
				$("#tr_item_loading").before($new_item);
			});
			$("#tr_item_loading").slideUp(100);
		},
		error : function(data) {

		}
	});
}

load_case_list = function($parent) {
	var item_id = $parent.find("input[name=itemid]").val().trim();
	$.ajax({
		url : "/index.php/api/case/list",
		type : "post",
		dataType : "json",
		data : {
			itemid : item_id
		},
		success : function(data) {
			var $load = $parent.next(".item_case_line").find(".case_loading");
			if (!data.length) {
				$load.find("img").hide();
				$load.find("span").text("暂无用例");
				return;
			}
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return true;
				}
				var $new_case = $parent.next(".item_case_line").find(".case_tmp").clone(true);
				$new_case.removeClass("case_tmp").attr("id", "tr_case_" + obj.id);
				$new_case.find(".level_icon").attr("title", "").attr("src", "/static/img/list/level_" + obj.level + ".jpg");
				$new_case.find("input[name=caseid]").val(obj.id);
				$new_case.find("input[name=casename]").val(obj.name);
				$new_case.find("input[name=sendtype]").val(obj.stype);
				$new_case.find("input[name=contenttype]").val(obj.ctype);
				$new_case.find("input[name=requestparam]").val(obj.param);
				$new_case.find("input[name=caselevel]").val(obj.level);
				$new_case.find("textarea[name=responseheader]").val(obj.header);
				$new_case.find("td[class=td_case_id]").attr("title", obj.name).find("span").text("Case-" + obj.id + "  :  " + obj.name);
				$load.before($new_case);
			});
			$load.slideUp(100);
		},
		error : function(data) {

		}
	});
}

public_page_recall = function(page) {
	$(".item_line:not(.item_tmp)").remove();
	$(".item_case_line:not(.item_case_tmp)").remove();
	$("#tr_item_loading").show();
	var module_id = parseInt($(".module_selected").find("input[name=moduleid]").val().trim());
	load_item_list(module_id, page, 10);
}