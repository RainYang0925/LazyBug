$(document).ready(function() {

	$("#checkbox_smtpssl").click(function() {
		if ($("#checkbox_smtpdefaultport").prop("checked")) {
			if ($("#checkbox_smtpssl").prop("checked")) {
				$("#input_smtpport").val(465);
			} else {
				$("#input_smtpport").val(25);
			}
		}
	});

	$("#checkbox_smtpdefaultport").click(function() {
		if ($("#checkbox_smtpdefaultport").prop("checked")) {
			$("#input_smtpport").attr("disabled", "disabled");
			if ($("#checkbox_smtpssl").prop("checked")) {
				$("#input_smtpport").val(465);
			} else {
				$("#input_smtpport").val(25);
			}
		} else {
			$("#input_smtpport").removeAttr("disabled");
		}
	});

	$("#div_mail_update").click(function() {
		if (!global_form_check(form_mail_items)) {
			return;
		}
		var smtp_server = $("#input_smtpserver").val().trim();
		var smtp_port = $("#input_smtpport").val().trim();
		var smtp_user = $("#input_smtpuser").val().trim();
		var smtp_password = $("#input_smtppassword").val().trim();
		var smtp_ssl = $("#checkbox_smtpssl").prop("checked") ? 1 : 0;
		var smtp_default_port = $("#checkbox_smtpdefaultport").prop("checked") ? 1 : 0;
		var mail_list = $("#input_maillist").val().trim();
		$(this).hide();
		$("#div_loading").show();
		request_mail_update(smtp_server, smtp_port, smtp_user, smtp_password, smtp_ssl, smtp_default_port, mail_list);
	});
});