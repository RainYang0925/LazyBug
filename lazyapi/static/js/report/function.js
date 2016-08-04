request_result_info = function(history_id) {
	$.ajax({
		url : "/index.php/api/result/info",
		type : "post",
		dataType : "json",
		data : {
			historyid : history_id
		},
		success : function(data) {
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return;
				}
				var $new_result = $(".result_tmp").clone(true);
				$new_result.removeClass("result_tmp");
				$new_result.find("input[name=itemid]").val(obj.item_id);
				$new_result.find(".item_name").find("span").text(obj.name);
				$new_result.find(".item_name").find("span").addClass(obj.pass ? "item_pass" : "item_fail");
				$.each(obj.case_list, function(index, obj) {
					if (!obj.id) {
						return true;
					}
					var notice = obj.pass ? "<span class=\"case_pass\">[ PASS ]</span>" : "<span class=\"case_fail\">[ FAIL ]</span>";
					var $new_result_case = $new_result.find(".result_case_tmp").clone(true);
					$new_result_case.removeClass("result_case_tmp");
					$new_result_case.find("input[name=caseid]").val(obj.case_id);
					$new_result_case.find(".case_name").find("span").html(obj.name.htmlspecials() + notice);
					$new_result.find(".result_case_tmp").before($new_result_case);
				});
				$(".result_tmp").before($new_result);
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

request_result_content = function($parent) {
	var result_id = $parent.find("input[name=resultid]").val().trim();
	$.ajax({
		url : "/index.php/api/result/content",
		type : "post",
		dataType : "text",
		data : {
			resultid : result_id
		},
		success : function(data) {
			$parent.next(".item_case_detail_line").find("span").text(data);
		},
		error : function(data) {
		}
	});
}

load_step_list = function($parent) {
	var history_id = $("#input_reload_id").val().trim();
	var item_id = $parent.parent().parent().find("input[name=itemid]").val().trim();
	var case_id = $parent.find("input[name=caseid]").val().trim();
	$.ajax({
		url : "/index.php/api/result/step",
		type : "post",
		dataType : "json",
		data : {
			historyid : history_id,
			itemid : item_id,
			caseid : case_id
		},
		success : function(data) {
			var $load = $parent.next(".item_case_step_line").find(".step_loading");
			if (!data.length) {
				$load.find("img").hide();
				$load.find("span").text("没有测试步骤");
				return;
			}
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return true;
				}
				var $new_result_step = $parent.next(".item_case_step_line").find(".result_step_tmp").clone(true);
				$new_result_step.removeClass("result_step_tmp");
				if (obj.step_type === "检查点") {
					$new_result_step.find(".step_icon").find("img").attr("src", "/static/img/report/step_check.png");
				} else if (obj.step_type === "存储查询") {
					$new_result_step.find(".step_icon").find("img").attr("src", "/static/img/report/step_store.png");
				} else {
					$new_result_step.find(".step_icon").find("img").attr("src", "/static/img/report/step_call.png");
				}
				$new_result_step.find("input[name=resultid]").val(obj.id);
				$new_result_step.find(".step_name").find("span").text(obj.name);
				$load.before($new_result_step);
			});
			$load.slideUp(100);
		},
		error : function(data) {

		}
	});
}