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
		dataType : "json",
		data : {
			resultid : result_id
		},
		success : function(data) {
			if (data.type === "接口调用") {
				var $new_item_case_detail_content = $(".item_case_detail_tmp").clone(true);
				$new_item_case_detail_content.removeClass("item_case_detail_tmp");
				$new_item_case_detail_content.find(".item_case_detail_title").find("span").text("● 运行结果");
				$new_item_case_detail_content.find(".item_case_detail_text").find("span").text(data.content);
				$new_item_case_detail_content.css("background-color", "#def5dc");
				$parent.find(".step_result").append($new_item_case_detail_content);
				$new_item_case_detail_content.show();
				var $new_item_case_detail_value1 = $(".item_case_detail_tmp").clone(true);
				$new_item_case_detail_value1.removeClass("item_case_detail_tmp");
				$new_item_case_detail_value1.find(".item_case_detail_title").find("span").text("● 请求地址");
				$new_item_case_detail_value1.find(".item_case_detail_text").find("span").text(data.value1);
				$parent.find(".step_result").append($new_item_case_detail_value1);
				$new_item_case_detail_value1.show();
				var $new_item_case_detail_value2 = $(".item_case_detail_tmp").clone(true);
				$new_item_case_detail_value2.removeClass("item_case_detail_tmp");
				$new_item_case_detail_value2.find(".item_case_detail_title").find("span").text("● 请求参数");
				$new_item_case_detail_value2.find(".item_case_detail_text").find("span").text(data.value2);
				$parent.find(".step_result").append($new_item_case_detail_value2);
				$new_item_case_detail_value2.show();
				var $new_item_case_detail_value3 = $(".item_case_detail_tmp").clone(true);
				$new_item_case_detail_value3.removeClass("item_case_detail_tmp");
				$new_item_case_detail_value3.find(".item_case_detail_title").find("span").text("● 自定义请求头");
				$new_item_case_detail_value3.find(".item_case_detail_text").find("span").text(data.value3);
				$parent.find(".step_result").append($new_item_case_detail_value3);
				$new_item_case_detail_value3.show();
			} else if (data.type === "存储查询") {
				var $new_item_case_detail_content = $(".item_case_detail_tmp").clone(true);
				$new_item_case_detail_content.removeClass("item_case_detail_tmp");
				$new_item_case_detail_content.find(".item_case_detail_title").find("span").text("● 运行结果");
				$new_item_case_detail_content.find(".item_case_detail_text").find("span").text(data.content);
				$new_item_case_detail_content.css("background-color", "#def5dc");
				$parent.find(".step_result").append($new_item_case_detail_content);
				$new_item_case_detail_content.show();
				var $new_item_case_detail_value1 = $(".item_case_detail_tmp").clone(true);
				$new_item_case_detail_value1.removeClass("item_case_detail_tmp");
				$new_item_case_detail_value1.find(".item_case_detail_title").find("span").text("● 查询语句");
				$new_item_case_detail_value1.find(".item_case_detail_text").find("span").text(data.value1);
				$parent.find(".step_result").append($new_item_case_detail_value1);
				$new_item_case_detail_value1.show();
			} else if (data.type === "检查点") {
				var $new_item_case_detail_content = $(".item_case_detail_tmp").clone(true);
				$new_item_case_detail_content.removeClass("item_case_detail_tmp");
				$new_item_case_detail_content.find(".item_case_detail_title").find("span").text("● 运行结果");
				$new_item_case_detail_content.find(".item_case_detail_text").find("span").text(data.content);
				$new_item_case_detail_content.css("background-color", "#def5dc");
				$parent.find(".step_result").append($new_item_case_detail_content);
				$new_item_case_detail_content.show();
				var $new_item_case_detail_value1 = $(".item_case_detail_tmp").clone(true);
				$new_item_case_detail_value1.removeClass("item_case_detail_tmp");
				$new_item_case_detail_value1.find(".item_case_detail_title").find("span").text("● 原始文本");
				$new_item_case_detail_value1.find(".item_case_detail_text").find("span").text(data.value1);
				$parent.find(".step_result").append($new_item_case_detail_value1);
				$new_item_case_detail_value1.show();
				var $new_item_case_detail_value2 = $(".item_case_detail_tmp").clone(true);
				$new_item_case_detail_value2.removeClass("item_case_detail_tmp");
				$new_item_case_detail_value2.find(".item_case_detail_title").find("span").text("● 目标匹配值");
				$new_item_case_detail_value2.find(".item_case_detail_text").find("span").text(data.value2);
				$parent.find(".step_result").append($new_item_case_detail_value2);
				$new_item_case_detail_value2.show();
			}
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