form_space_items = {
	name : {
		empty : 0,
		type : "input",
		name : "spacename",
		pass : "空间名称，如：支付项目",
		fail : "请输入空间名称"
	}
}

request_space_add = function(space_name) {
	$.ajax({
		url : "/index.php/api/space/add",
		type : "post",
		dataType : "json",
		data : {
			spacename : space_name
		},
		success : function(data) {
			if (data.code === "110011") {
				$("#input_spacename").val("");
				global_input_show("spacename", 0, "空间 < " + space_name + " > 已存在");
				return;
			}
			var space_id = parseInt(data.message);
			if (!space_id) {
				global_board_show("space", -1, 0);
				return;
			}
			var $new_space = $(".space_tmp").clone(true);
			$new_space.removeClass("space_tmp").attr("id", "div_space_" + space_id);
			$new_space.find("input[name=spaceid]").val(space_id);
			$new_space.find(".space_name").find("span").text(space_name);
			$("#div_space_loading").before($new_space);
			$("#div_space_loading").slideUp(100);
			global_board_show("space", -1, 1);
		},
		error : function(data) {
			global_board_show("space", -1, 0);
		}
	});
}

request_space_update = function(space_id, space_name) {
	$.ajax({
		url : "/index.php/api/space/update",
		type : "post",
		dataType : "json",
		data : {
			spaceid : space_id,
			spacename : space_name
		},
		success : function(data) {
			if (data.code === "110012") {
				$("#input_spacename").val("");
				global_input_show("spacename", 0, "空间 < " + space_name + " > 已存在");
				return;
			}
			$("#div_space_" + space_id).find(".space_name").find("span").text(space_name);
			global_board_show("space", -1, 1);
		},
		error : function(data) {
			global_board_show("space", -1, 0);
		}
	});
}

request_space_delete = function(space_id) {
	$.ajax({
		url : "/index.php/api/space/delete",
		type : "post",
		dataType : "json",
		data : {
			spaceid : space_id
		},
		success : function(data) {
			$("#div_space_" + space_id).remove();
			global_board_show("delete_space", 0, 0);
		},
		error : function(data) {
			global_board_show("delete_space", 0, 0);
		}
	});
}

load_space_list = function() {
	$.ajax({
		url : "/index.php/api/space/list",
		type : "post",
		dataType : "json",
		data : {},
		success : function(data) {
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return true;
				}
				var $new_space = $(".space_tmp").clone(true);
				$new_space.removeClass("space_tmp").attr("id", "div_space_" + obj.id);
				$new_space.find("input[name=spaceid]").val(obj.id);
				$new_space.find(".space_name").find("span").text(obj.name);
				$("#div_space_loading").before($new_space);
			});
			$("#div_space_loading").slideUp(100);
		},
		error : function(data) {

		}
	});
}