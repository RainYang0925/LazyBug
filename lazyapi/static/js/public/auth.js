$(document).ready(function() {
	id = setInterval("public_auth_change_time()", 1000);
});

public_auth_change_time = function() {
	var time = parseInt($("#div_number>span").text());
	if (time > 1) {
		$("#div_number>span").text(--time);
	} else {
		clearInterval(id);
		window.location.href = "/";
	}
}