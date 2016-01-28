(function() {
	var path_name = window.document.location.pathname;
	var user_agent = navigator.userAgent;
	if (/MSIE ([^;]+)/.test(user_agent)) {
		path_name === "/index.php/browser" || (window.location.href = "/index.php/browser");
	} else {
		path_name === "/index.php/browser" && (window.location.href = "/index.php");
	}
})();

$(document).ready(function() {
	$("#div_global_menu").height(window.innerHeight);
	$("#div_global_head").width(window.innerWidth - 121);

	$(window).resize(function() {
		$("#div_global_menu").height(window.innerHeight);
		$("#div_global_head").width(window.innerWidth - 121);
	});
});

String.prototype.replaceAll = function(s1, s2) {
	return this.replace(new RegExp(s1, "gm"), s2);
}

String.prototype.limit = function(length) {
	var string = this.toString();
	return string.length > length ? string.substring(0, length) + "..." : string;
}

String.prototype.htmlspecials = function() {
	var string = this.toString();
	if (string.length > 0) {
		string = string.replaceAll("&", "&amp;");
		string = string.replaceAll(">", "&gt;");
		string = string.replaceAll("<", "&lt;");
		string = string.replaceAll(String.valueOf(39), "'");
		string = string.replaceAll(String.valueOf(34), "&quot;");
	}
	return string;
}

global_board_show = function(name, status, notice) {
	if (status < 0) {
		$("#div_" + name).slideUp(300);
		$("#div_" + name + "_notice").slideDown(300);
		if (notice > 0) {
			$("#div_" + name + "_success").show();
		} else {
			$("#div_" + name + "_error").show();
		}
	} else if (status > 0) {
		if (notice) {
			$("#div_" + name + "_notice").hide();
			$("#div_" + name + "_success").hide();
			$("#div_" + name + "_error").hide();
		}
		$("#div_global_lock").show();
		$("#div_" + name).slideDown(300);
	} else {
		if (notice) {
			$("#div_" + name + "_notice").hide();
		}
		$("#div_" + name).slideUp(300);
		$("#div_global_lock").hide();
	}
}

global_select_show = function(name, status) {
	if (status) {
		if (status === 2) {
			$("#select_" + name).removeClass("global_input_error");
			$("#select_" + name).addClass("global_input_success");
		} else {
			$("#select_" + name).removeClass("global_input_success");
			$("#select_" + name).removeClass("global_input_error");
		}
	} else {
		$("#select_" + name).removeClass("global_input_success");
		$("#select_" + name).addClass("global_input_error");
	}
}

global_input_show = function(name, status, placeholder) {
	if (status) {
		if (status === 2) {
			$("#input_" + name).removeClass("global_input_error");
			$("#input_" + name).addClass("global_input_success");
			$("#input_" + name).attr("placeholder", placeholder);
		} else {
			$("#input_" + name).removeClass("global_input_success");
			$("#input_" + name).removeClass("global_input_error");
			$("#input_" + name).attr("placeholder", placeholder);
		}
	} else {
		$("#input_" + name).removeClass("global_input_success");
		$("#input_" + name).addClass("global_input_error");
		$("#input_" + name).attr("placeholder", placeholder);
	}
}

global_form_check = function(items) {
	try {
		$.each(items, function(i, item) {
			if (item.empty !== 0) {
				return true;
			}
			if (item.type === "input") {
				if ($("#input_" + item.name).val().trim()) {
					global_input_show(item.name, 1, item.pass);
				} else {
					global_input_show(item.name, 0, item.fail);
					throw "error";
				}
			} else if (item.type === "select") {
				if ($("#select_" + item.name).val() && $("#select_" + item.name).val().trim()) {
					global_select_show(item.name, 1);
				} else {
					global_select_show(item.name, 0);
					throw "error";
				}
			}
		});
	} catch (e) {
		return 0;
	}
	return 1;
}

global_form_reset = function(items) {
	$.each(items, function(i, item) {
		if (item.empty === 0) {
			if (item.type === "input") {
				global_input_show(item.name, 1, item.pass);
			} else if (item.type === "select") {
				global_select_show(item.name, 1, item.pass);
			}
		}
	});
}

global_form_clear = function(items) {
	$.each(items, function(i, item) {
		if (item.type === "input") {
			$("#input_" + item.name).val("");
		} else if (item.type === "select") {
			$("#select_" + item.name).val(item.def);
		} else if (item.type === "checkbox") {
			$("#checkbox_" + item.name).attr("checked", false);
		}
	});
}