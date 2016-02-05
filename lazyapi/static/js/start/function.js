form_api_items = {
	url : {
		empty : 0,
		type : "input",
		name : "itemurl",
		pass : "接口请求地址，如：http://www.lazybug.cn/api/demo",
		fail : "请输入接口请求地址"
	}
}

form_case_items = {
	itemname : {
		empty : 0,
		type : "input",
		name : "itemname",
		pass : "接口名称，如：用户登录",
		fail : "请输入接口名称"
	},
	casename : {
		empty : 0,
		type : "input",
		name : "casename",
		pass : "用例名称，如：使用正确帐号登录",
		fail : "请输入用例名称"
	}
}

request_item_info = function(item_id, case_data) {
	$.ajax({
		url : "/index.php/api/item/info",
		type : "post",
		dataType : "json",
		data : {
			itemid : item_id
		},
		success : function(data) {
			if (data && data.id) {
				reload_succ(data, case_data);
			} else {
				reload_fail();
			}
		},
		error : function(data) {
			reload_fail();
		}
	});
}

request_case_info = function(case_id) {
	$.ajax({
		url : "/index.php/api/case/info",
		type : "post",
		dataType : "json",
		data : {
			caseid : case_id
		},
		success : function(data) {
			if (data && data.id) {
				request_item_info(data.item_id, data);
			} else {
				reload_fail();
			}
		},
		error : function(data) {
			reload_fail();
		}
	});
}

request_case_save = function(item_name, case_name, send_type, content_type, item_url) {
	$.ajax({
		url : "/index.php/api/case/save",
		type : "post",
		dataType : "json",
		data : {
			itemname : item_name,
			casename : case_name,
			sendtype : send_type,
			contenttype : content_type,
			itemurl : item_url,
			requestparam : get_params(),
			responseheader : get_headers()
		},
		success : function(data) {
			global_board_show("case", -1, 1);
		},
		error : function(data) {
			global_board_show("case", -1, 0);
		}
	});
}

request_case_request = function(send_type, content_type, item_url) {
	$.ajax({
		url : "/index.php/api/case/request",
		type : "post",
		dataType : "json",
		data : {
			sendtype : send_type,
			contenttype : content_type,
			itemurl : item_url,
			requestparam : get_params(),
			requestheader : get_headers()
		},
		success : function(data) {
			$("#span_data").text(data.response);
			$("#span_header").text(data.header);
			output_data();
			change_status(1);
		},
		error : function(data) {
			$("#span_data").text("请求错误，请检查后重试");
			$("#span_header").text();
			output_data();
			change_status(1);
		}
	});
}

get_params = function() {
	var send_type = $("#select_sendtype").val();
	var content_type = $("#select_contenttype").val();
	if (content_type === "application/x-www-form-urlencoded") {
		return get_json($("input[name=encodekey]"), $("input[name=encodevalue]"), null);
	} else if (content_type === "multipart/form-data") {
		return get_json($("input[name=formkey]"), $("input[name=formvalue]"), $("select[name=formtype]"));
	} else {
		return $("#input_raw").val().trim();
	}
}

get_headers = function() {
	return get_json($("input[name=headerkey]"), $("input[name=headervalue]"), $("select[name=headertype]"));
}

get_json = function($keys, $values, $types) {
	var obj = new Object();
	$.each($keys, function(i) {
		var $key = $($keys.get(i));
		var $value = $($values.get(i));
		var key = $key.val().trim();
		var value = $value.val().trim().replace(new RegExp("\"", "gm"), "\\\"");
		$key.removeClass("global_input_error");
		$value.removeClass("global_input_error");
		if (!key) {
			return true;
		}
		try {
			if ($types === null) {
				eval("obj." + key + "=\"" + value + "\";");
			} else if ($($types.get(i)).val().trim() === "NUM") {
				eval("obj." + key + "=" + parseInt(value) + ";");
			} else if ($($types.get(i)).val().trim() === "FILE") {
				eval("obj." + key + "=\"@" + value + "\";");
			} else {
				eval("obj." + key + "=\"" + value + "\";");
			}
		} catch (e) {
			$key.addClass("global_input_error");
			$value.addClass("global_input_error");
		}
	});
	return JSON.stringify(obj);
}

switch_form = function(content) {
	switch (content) {
	case "application/x-www-form-urlencoded":
		$("#div_form_data").hide();
		$("#div_raw").hide();
		$("#div_form_encode").show();
		break;
	case "multipart/form-data":
		$("#div_form_encode").hide();
		$("#div_raw").hide();
		$("#div_form_data").show();
		break;
	default:
		$("#div_form_encode").hide();
		$("#div_form_data").hide();
		$("#div_raw").show();
	}
}

output_data = function() {
	var type = $("#input_data").val().trim();
	var data = (type === "header") ? $("#span_header").text() : $("#span_data").text();
	if (!data) {
		$("#span_result").text("");
		return;
	}
	if (type === "json") {
		try {
			$data = $.parseJSON(data);
			$("#span_result").html(public_format_json($data, ""));
		} catch (e) {
			$("#span_result").text("非JSON格式内容！");
		}
	} else if (type === "xml") {
		try {
			$data = $($.parseXML(data.trim())).find("*").eq(0);
			$("#span_result").html(public_format_xml($data, ""));
		} catch (e) {
			$("#span_result").text("非XML格式内容！");
		}
	} else if (type === "header") {
		$("#span_result").html(public_format_header(data));
	} else {
		$("#span_result").text(data);
	}
}

change_status = function(status) {
	if (status) {
		$("#div_disable").hide();
		$("#img_loading").hide();
		$("#div_enable").show();
		$("#img_up").show();
	} else {
		$("#div_enable").hide();
		$("#img_up").hide();
		$("#div_disable").show();
		$("#img_loading").show();
	}
}