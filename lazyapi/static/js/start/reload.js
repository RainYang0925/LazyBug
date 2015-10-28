reload = function() {
	var reload_id = parseInt($("#input_reload_id").val().trim());
	if (reload_id > 0) {
		global_board_show("reload", 1, 0);
		request_case_info(reload_id);
	}
}

reload_succ = function(item_data, case_data) {
	$("#input_itemname").attr("readonly", "true").addClass("global_input_disable");
	$("#input_itemname").val(item_data.name);
	$("#input_itemurl").val(item_data.url);
	$("#input_casename").val(case_data.name);
	$("#select_sendtype").val(case_data.type);
	reset_param(case_data.param);
	reset_header(case_data.header);
	setTimeout(function() {
		global_board_show("reload", 0, 0);
	}, 500);
}

reload_fail = function() {
	setTimeout(function() {
		global_board_show("reload", 0, 0);
	}, 500);
}

reset_param = function(params) {
	params = params.split("&");
	if (params && params.length > 0) {
		var $parent = $("input[name=itemkey]").parent().parent();
		$.each(params, function() {
			var param = this.split("=");
			if (param && param.length === 2) {
				var $new_node = $parent.clone(true);
				$new_node.find("input[name=itemkey]").val(decodeURIComponent(param[0]));
				$new_node.find("input[name=itemvalue]").val(decodeURIComponent(param[1]));
				$parent.before($new_node);
			}
		});
		if ($("input[name=itemkey]").length > 1) {
			$parent.remove();
		}
	}
}

reset_header = function(headers) {
	var $parent = $("input[name=headerkey]").parent().parent();
	try {
		$.each($.parseJSON(headers), function(key, value) {
			var $new_node = $parent.clone(true);
			$new_node.find("input[name=headerkey]").val(key);
			$new_node.find("input[name=headervalue]").val(value);
			if (typeof (value) === "number") {
				$new_node.find("select").val("NUM");
			}
			$parent.before($new_node);
		});
	} catch (e) {

	}
	if ($("input[name=headerkey]").length > 1) {
		$parent.remove();
	}
}