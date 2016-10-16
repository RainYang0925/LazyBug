$(document).ready(function() {

	$("#img_run").unbind().attr("src", "/static/img/public/menu_run_enable.jpg");

	$("#div_menu_run").removeClass("global_menu_disable").addClass("global_menu_enable");

	reload();

	$(".result_case_line").click(function() {
		var $next = $(this).next(".item_case_step_line");
		if ($next.length) {
			$next.toggle();
		} else {
			var $new_item_case_step = $(".item_case_step_tmp").clone(true);
			$new_item_case_step.removeClass("item_case_step_tmp");
			$(this).after($new_item_case_step);
			$new_item_case_step.show();
			load_step_list($(this));
		}
		if ($next.is(":hidden")) {
			$(this).find(".case_icon").find("img").attr("src", "/static/img/report/fade_in.png");
		} else {
			$(this).find(".case_icon").find("img").attr("src", "/static/img/report/fade_out.png");
		}
	});

	$(".result_step_line").click(function() {
		var $result = $(this).find(".step_result").find(".item_case_detail_line");
		if ($result.length) {
			$result.toggle();
		} else {
			request_result_content($(this));
		}
	});
});