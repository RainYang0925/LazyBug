$(document).ready(function() {

	form_user_items = {
		name : {
			empty : 0,
			type : "input",
			name : "username",
			pass : "用户名",
			fail : "请输入用户名"
		},
		password : {
			empty : 0,
			type : "input",
			name : "password",
			pass : "密码",
			fail : "请输入密码"
		}
	}

	$("#div_box>input").val("1");

	$("#img_submit_out").mouseover(function() {
		$("#img_submit_in").stop().fadeIn(300);
	});

	$("#img_submit_in").hover(function() {
		$(this).stop().fadeIn(300);
	}, function() {
		$(this).stop().fadeOut(300);
	});

	$("#div_box").click(function() {
		if ($("#div_box>input").val().trim() === "1") {
			$(this).css("background-position", "0px 0px");
			$("#div_box>input").val("0");
		} else {
			$(this).css("background-position", "0px -17px");
			$("#div_box>input").val("1");
		}
	});

	$("#div_remember").click(function() {
		if ($("#div_box>input").val().trim() === "1") {
			$("#div_box").css("background-position", "0px 0px");
			$("#div_box>input").val("0");
		} else {
			$("#div_box").css("background-position", "0px -17px");
			$("#div_box>input").val("1");
		}
	});

	$("#div_submit").click(function() {
		if (!global_form_check(form_user_items)) {
			return;
		}
		$.post("/index.php/api/login", $("#form_login").serialize(), function(data, status) {
			if (status !== "success") {
				return;
			}
			data = JSON.parse(data);
			if (data.code === "000000") {
				window.location.href = "/index.php";
				return;
			}
			$("#input_password").attr("placeholder", "登录验证失败，请重新确认");
			$("#input_username").addClass("global_input_error");
			$("#input_password").addClass("global_input_error");
			$("#input_password").val("");
		});
	});
});