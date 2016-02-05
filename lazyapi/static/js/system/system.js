$(document).ready(function() {

	$("#div_mail_update").click(function() {
		if (!global_form_check(form_mail_items)) {
			return;
		}
		var smtp_server = $("#input_smtpserver").val().trim();
		var smtp_port = $("#input_smtpport").val().trim();
		var smtp_user = $("#input_smtpuser").val().trim();
		var smtp_password = $("#input_smtppassword").val().trim();
		var mail_list = $("#input_maillist").val().trim();
		$(this).hide();
		$("#div_loading").show();
		request_mail_update(smtp_server, smtp_port, smtp_user, smtp_password, mail_list);
	});
});