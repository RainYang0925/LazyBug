$(document).ready(function() {

	$(".global_page_first").hover(function() {
		$(this).find("img").attr("src", "/static/img/public/page_first_enable.jpg");
	}, function() {
		$(this).find("img").attr("src", "/static/img/public/page_first_disable.jpg");
	});

	$(".global_page_first").click(function() {
		$(".global_page_num:not(.global_page_tmp)").remove();
		public_page_load(1);
		typeof (public_page_recall) === "function" && public_page_recall(1);
	});

	$(".global_page_previous").hover(function() {
		$(this).find("img").attr("src", "/static/img/public/page_previous_enable.jpg");
	}, function() {
		$(this).find("img").attr("src", "/static/img/public/page_previous_disable.jpg");
	});

	$(".global_page_previous").click(function() {
		var current = public_page_current();
		current = current - 1 > 0 ? current - 1 : 1;
		$(".global_page_num:not(.global_page_tmp)").remove();
		typeof (public_page_recall) === "function" && public_page_recall(current);
		public_page_load(current);
	});

	$(".global_page_num").click(function() {
		var page = $(this).find("span").text();
		$(".global_page_num:not(.global_page_tmp)").remove();
		typeof (public_page_recall) === "function" && public_page_recall(page);
		public_page_load(page);
	});

	$(".global_page_next").hover(function() {
		$(this).find("img").attr("src", "/static/img/public/page_next_enable.jpg");
	}, function() {
		$(this).find("img").attr("src", "/static/img/public/page_next_disable.jpg");
	});

	$(".global_page_next").click(function() {
		var total = public_page_total();
		var current = public_page_current();
		current = current + 1 < total ? current + 1 : total;
		$(".global_page_num:not(.global_page_tmp)").remove();
		typeof (public_page_recall) === "function" && public_page_recall(current);
		public_page_load(current);
	});

	$(".global_page_last").hover(function() {
		$(this).find("img").attr("src", "/static/img/public/page_last_enable.jpg");
	}, function() {
		$(this).find("img").attr("src", "/static/img/public/page_last_disable.jpg");
	});

	$(".global_page_last").click(function() {
		var total = public_page_total();
		$(".global_page_num:not(.global_page_tmp)").remove();
		typeof (public_page_recall) === "function" && public_page_recall(total);
		public_page_load(total);
	});
});

public_page_current = function() {
	var current = parseInt($(".global_page_current").text());
	return current > 0 ? current : 1;
}

public_page_total = function() {
	var total = parseInt($("#input_page_count").val().trim());
	return total > 0 ? total : 1;
}

public_page_load = function(current) {
	var min = max = 1;
	var total = public_page_total();
	$(".global_page_current").text(current);
	if (total <= 10) {
		max = total;
	} else {
		if (current > 5) {
			if (total - current > 5) {
				min = current - 4;
				max = current + 5;
			} else {
				min = total - 9;
				max = total;
			}
		} else {
			max = 10;
		}
	}
	for ( var i = min; i < current; i++) {
		$new_page = $(".global_page_tmp").clone(true);
		$new_page.removeClass("global_page_tmp").find("span").text(i);
		$(".global_page_current").before($new_page);
	}
	for ( var i = max; i > current; i--) {
		$new_page = $(".global_page_tmp").clone(true);
		$new_page.removeClass("global_page_tmp").find("span").text(i);
		$(".global_page_current").after($new_page);
	}
}