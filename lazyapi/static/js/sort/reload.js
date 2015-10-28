reload = function() {
	var reload_id = parseInt($("#input_reload_id").val().trim());
	if (reload_id > 0) {
		global_board_show("reload", 1, 0);
		request_step_info(reload_id);
	}
}