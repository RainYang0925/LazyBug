$(document).ready(function() {

	$("#img_start").unbind().attr("src", "/static/img/public/menu_start_enable.jpg");

	$("#div_menu_start").removeClass("global_menu_disable").addClass("global_menu_enable");

	reload();

	$("#select_sendtype").change(function() {
		if ($(this).val() === "GET") {
			$("#select_contenttype").val("application/x-www-form-urlencoded");
			$("#select_contenttype").attr("disabled", "disabled").addClass("global_input_disable");
		} else {
			$("#select_contenttype").removeAttr("disabled").removeClass("global_input_disable");
		}
		switch_form($("#select_contenttype").val());
	});

	$("#select_contenttype").change(function() {
		switch_form($(this).val());
	});

	$(".icon").parent().hover(function() {
		$(this).find(".icon_item").stop().fadeIn(100);
	}, function() {
		$(this).find(".icon_item").stop().fadeOut(100);
	});

	$(".icon_reset").click(function() {
		var $parent = $(this).parent().parent().parent();
		$parent.find("input").val("");
		$parent.find("select").val("TEXT");
		$parent.find("input").removeClass("global_input_error");
	});

	$(".icon_add").click(function() {
		var $parent = $(this).parent().parent().parent();
		var $new_node = $parent.clone(true);
		$new_node.find("input").val("");
		$new_node.find("select").val("TEXT");
		$new_node.find("input").removeClass("global_input_error");
		$new_node.find(".icon_item").hide();
		$parent.after($new_node);
	});

	$(".icon_delete_encodekey").click(function() {
		if ($("input[name=encodekey]").length > 1) {
			var $parent = $(this).parent().parent().parent();
			$parent.remove();
		}
	});

	$(".icon_delete_formkey").click(function() {
		if ($("input[name=formkey]").length > 1) {
			var $parent = $(this).parent().parent().parent();
			$parent.remove();
		}
	});

	$(".icon_delete_headerkey").click(function() {
		if ($("input[name=headerkey]").length > 1) {
			var $parent = $(this).parent().parent().parent();
			$parent.remove();
		}
	});

	$("#img_up").click(function() {
		if (!global_form_check(form_api_items)) {
			return;
		}
		global_form_reset(form_case_items);
		global_board_show("case", 1, 1);
	});

	$(".save_close").click(function() {
		global_board_show("case", 0, 1);
	});

	$(".save_cancel").click(function() {
		global_board_show("case", 0, 1);
	});

	$("#img_save_ok").click(function() {
		if (!global_form_check(form_case_items)) {
			return;
		}
		var send_type = $("#select_sendtype").val().trim();
		var content_type = $("#select_contenttype").val().trim();
		var item_url = $("#input_itemurl").val().trim();
		var item_name = $("#input_itemname").val().trim();
		var case_name = $("#input_casename").val().trim();
		request_case_save(item_name, case_name, send_type, content_type, item_url);
	});

	$("#a_send").click(function() {
		change_status(0);
		$("#span_data").text("");
		$("#span_header").text("");
		$("#span_result").text("");
		if (!global_form_check(form_api_items)) {
			change_status(1);
			return;
		}
		global_form_reset(form_api_items);
		var send_type = $("#select_sendtype").val().trim();
		var content_type = $("#select_contenttype").val().trim();
		var item_url = $("#input_itemurl").val().trim();
		request_case_request(send_type, content_type, item_url);
	});

	$("#div_data").click(function() {
		$(this).addClass("result_enable");
		$("#div_json").removeClass("result_enable");
		$("#div_xml").removeClass("result_enable");
		$("#div_header").removeClass("result_enable");
		$("#input_data").val("data");
		output_data();
	});

	$("#div_json").click(function() {
		$(this).addClass("result_enable");
		$("#div_data").removeClass("result_enable");
		$("#div_xml").removeClass("result_enable");
		$("#div_header").removeClass("result_enable");
		$("#input_data").val("json");
		output_data();
	});

	$("#div_xml").click(function() {
		$(this).addClass("result_enable");
		$("#div_data").removeClass("result_enable");
		$("#div_json").removeClass("result_enable");
		$("#div_header").removeClass("result_enable");
		$("#input_data").val("xml");
		output_data();
	});

	$("#div_header").click(function() {
		$(this).addClass("result_enable");
		$("#div_data").removeClass("result_enable");
		$("#div_json").removeClass("result_enable");
		$("#div_xml").removeClass("result_enable");
		$("#input_data").val("header");
		output_data();
	});
});