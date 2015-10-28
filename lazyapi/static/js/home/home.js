$(document).ready(function() {

	$("#div_password_update").click(function() {
		if (!global_form_check(form_password_items)) {
			return;
		}
		var old_password = $("#input_oldpassword").val().trim();
		var new_password = $("#input_newpassword").val().trim();
		var check_password = $("#input_checkpassword").val().trim();
		if (new_password !== check_password) {
			$("#input_checkpassword").val("");
			global_input_show("checkpassword", 0, "两次密码输入不一致，请确认");
			return;
		}
		request_password_update(old_password, new_password);
	});
});