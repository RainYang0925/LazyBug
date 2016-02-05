form_mail_items = {
	smtpserver : {
		empty : 0,
		type : "input",
		name : "smtpserver",
		pass : "SMTP服务器地址",
		fail : "请输入服务器地址"
	},
	smtpport : {
		empty : 0,
		type : "input",
		name : "smtpport",
		pass : "端口号",
		fail : "端口号"
	},
	smtpuser : {
		empty : 1,
		type : "input",
		name : "smtpuser"
	},
	smtppassword : {
		empty : 1,
		type : "input",
		name : "smtppassword"
	},
	maillist : {
		empty : 1,
		type : "input",
		name : "maillist"
	}
}

request_mail_update = function(smtp_server, smtp_port, smtp_user, smtp_password, mail_list) {
	$.ajax({
		url : "/index.php/api/system/mail",
		type : "post",
		dataType : "json",
		data : {
			smtpserver : smtp_server,
			smtpport : smtp_port,
			smtpuser : smtp_user,
			smtppassword : smtp_password,
			maillist : mail_list,
		},
		success : function(data) {
			$("#div_loading").delay(300).hide(0, function() {
				$("#div_mail_update").show();
			});
		},
		error : function(data) {
			$("#div_loading").delay(300).hide(0, function() {
				$("#div_mail_update").show();
			});
		}
	});
}