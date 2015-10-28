form_user_items = {
	name : {
		empty : 0,
		type : "input",
		name : "username",
		pass : "用户名，如：guest",
		fail : "请输入用户名"
	},
	password : {
		empty : 1,
		type : "input",
		name : "userpassword"
	},
	role : {
		empty : 0,
		type : "select",
		name : "userrole",
		def : "normal"
	}
}

request_user_add = function(user_name, user_password, user_role) {
	$.ajax({
		url : "/api/user/add",
		type : "post",
		dataType : "json",
		data : {
			username : user_name,
			userpassword : user_password,
			userrole : user_role
		},
		success : function(data) {
			if (data.code === "990011") {
				$("#input_username").val("");
				global_input_show("username", 0, "用户名 < " + user_name + " > 已存在");
				return;
			}
			if (data.code === "990022") {
				$("#input_username").val("");
				global_input_show("username", 0, "用户名只能由数字、字母和下划线组成");
				return;
			}
			var user_id = parseInt(data.message);
			if (!user_id) {
				global_board_show("user", -1, 0);
				return;
			}
			var $new_user = $(".user_tmp").clone(true);
			$new_user.removeClass("user_tmp").attr("id", "tr_user_" + user_id);
			$new_user.find("input[name=userid]").val(user_id);
			$new_user.find("input[name=userrole]").val(user_role);
			$new_user.find(".td_user_name").find("span").text(user_name);
			$new_user.find(".td_user_role").find("span").text(get_role_name(user_role));
			$("#tr_user_loading").before($new_user);
			$("#tr_user_loading").slideUp(100);
			global_board_show("user", -1, 1);
		},
		error : function(data) {
			global_board_show("user", -1, 0);
		}
	});
}

request_user_update = function(user_id, user_name, user_password, user_role) {
	$.ajax({
		url : "/api/user/update",
		type : "post",
		dataType : "json",
		data : {
			userid : user_id,
			username : user_name,
			userpassword : user_password,
			userrole : user_role
		},
		success : function(data) {
			if (data.code === "990012") {
				$("#input_username").val("");
				global_input_show("username", 0, "用户名 < " + user_name + " > 已存在");
				return;
			}
			if (data.code === "990022") {
				$("#input_username").val("");
				global_input_show("username", 0, "用户名只能由数字、字母和下划线组成");
				return;
			}
			$("#tr_user_" + user_id).find(".td_user_role").find("span").text(get_role_name(user_role));
			global_board_show("user", -1, 1);
		},
		error : function(data) {
			global_board_show("user", -1, 0);
		}
	});
}

request_user_delete = function(user_id) {
	$.ajax({
		url : "/api/user/delete",
		type : "post",
		dataType : "json",
		data : {
			userid : user_id
		},
		success : function(data) {
			$("#tr_user_" + user_id).remove();
			global_board_show("delete_user", 0, 0);
		},
		error : function(data) {
			global_board_show("delete_user", 0, 0);
		}
	});
}

load_user_list = function(page, size) {
	$.ajax({
		url : "/api/user/list",
		type : "post",
		dataType : "json",
		data : {
			page : page,
			size : size
		},
		success : function(data) {
			$.each(data, function(index, obj) {
				if (!obj.id) {
					return true;
				}
				var $new_user = $(".user_tmp").clone(true);
				$new_user.removeClass("user_tmp").attr("id", "tr_user_" + obj.id);
				$new_user.find("input[name=userid]").val(obj.id);
				$new_user.find("input[name=userrole]").val(obj.role);
				$new_user.find(".td_user_name").find("span").text(obj.name);
				$new_user.find(".td_user_role").find("span").text(get_role_name(obj.role));
				if (obj.name === "admin") {
					$new_user.find(".user_remove").remove();
				}
				$("#tr_user_loading").before($new_user);
			});
			$("#tr_user_loading").slideUp(100);
		},
		error : function(data) {

		}
	});
}

get_role_name = function(role) {
	switch (role) {
	case "admin":
		return "系统管理员";
	case "editor":
		return "测试维护";
	case "normal":
		return "普通用户";
	}
}

public_page_recall = function(page) {
	$(".user_line:not(.user_tmp)").remove();
	$("#tr_user_loading").show();
	load_user_list(page, 20);
}