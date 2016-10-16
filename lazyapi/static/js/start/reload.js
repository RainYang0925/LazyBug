reload = function() {
	var reload_id = parseInt($("#input_reload_id").val().trim());
	if (reload_id > 0) {
		global_board_show("reload", 1, 0);
		request_case_info(reload_id);
	}
}

reload_succ = function(item_data, case_data) {
	$("#select_projectspace").val(item_data.space_id);
	$("#input_itemname").attr("readonly", "true").addClass("global_input_disable");
	$("#input_itemname").val(item_data.name);
	$("#input_itemurl").val(item_data.url);
	$("#input_casename").val(case_data.name);
	$("#select_sendtype").val(case_data.stype);
	$("#select_contenttype").val(case_data.ctype);
	if (case_data.stype !== "GET") {
		$("#select_contenttype").removeAttr("disabled").removeClass("global_input_disable");
	}
	switch_form(case_data.ctype);
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
	var send_type = $("#select_sendtype").val();
	var content_type = $("#select_contenttype").val();
	if (content_type === "application/x-www-form-urlencoded") {
		var $parent = $("input[name=encodekey]").parent().parent();
		try {
			$.each($.parseJSON(params), function(key, value) {
				var $new_node = $parent.clone(true);
				$new_node.find("input[name=encodekey]").val(key);
				$new_node.find("input[name=encodevalue]").val(value);
				$parent.before($new_node);
			});
		} catch (e) {

		}
		if ($("input[name=encodekey]").length > 1) {
			$parent.remove();
		}
	} else if (content_type === "multipart/form-data") {
		var $parent = $("input[name=formkey]").parent().parent();
		try {
			$.each($.parseJSON(params), function(key, value) {
				var $new_node = $parent.clone(true);
				if (value.substr(0, 1) === "@") {
					$new_node.find("select").val("FILE");
					value = value.substr(1);
				}
				$new_node.find("input[name=formkey]").val(key);
				$new_node.find("input[name=formvalue]").val(value);
				$parent.before($new_node);
			});
		} catch (e) {

		}
		if ($("input[name=formkey]").length > 1) {
			$parent.remove();
		}
	} else {
		$("#input_raw").val(params);
	}
}

reset_header = function(headers) {
	var $parent = $("input[name=headerkey]").parent().parent();
	try {
		$.each($.parseJSON(headers), function(key, value) {
			var $new_node = $parent.clone(true);
			if (typeof (value) === "number") {
				$new_node.find("select").val("NUM");
			}
			$new_node.find("input[name=headerkey]").val(key);
			$new_node.find("input[name=headervalue]").val(value);
			$parent.before($new_node);
		});
	} catch (e) {

	}
	if ($("input[name=headerkey]").length > 1) {
		$parent.remove();
	}
}