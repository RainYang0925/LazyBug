form_password_items = {
	oldpassword : {
		empty : 0,
		type : "input",
		name : "oldpassword",
		pass : "原密码",
		fail : "请输入原密码"
	},
	newpassword : {
		empty : 0,
		type : "input",
		name : "newpassword",
		pass : "新密码",
		fail : "请输入新密码"
	},
	checkpassword : {
		empty : 0,
		type : "input",
		name : "checkpassword",
		pass : "新密码确认",
		fail : "请输入确认密码"
	}
}

request_password_update = function(old_password, new_password) {
	$.ajax({
		url : "/index.php/api/user/password",
		type : "post",
		dataType : "json",
		data : {
			oldpassword : old_password,
			newpassword : new_password,
		},
		success : function(data) {
			if (data.code === "990023") {
				$("#input_oldpassword").val("");
				global_input_show("oldpassword", 0, "原密码错误，请确认");
				return;
			}
			$("#input_oldpassword").val("");
			$("#input_newpassword").val("");
			$("#input_checkpassword").val("");
			global_form_reset(form_password_items);
			global_input_show("oldpassword", 2, "密码修改成功");
		},
		error : function(data) {
		}
	});
}