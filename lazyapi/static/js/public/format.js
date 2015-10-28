public_format_json = function(data, space) {
	var result = "";
	var width = "<span class=\"global_json_space\"></span>";
	var indentation = space;
	result += indentation + "{ <br/>";
	space += width;
	$.each(data, function(key, value) {
		result += space + "<span class=\"global_json_key\">" + key.toString().htmlspecials() + "</span>" + " : ";
		if (value === null) {
			result += "<span class=\"global_json_value\">null</span>" + "<br/>";
		} else if (value instanceof Object) {
			result += "<br/>" + public_format_json(value, space + width);
		} else {
			result += "<span class=\"global_json_value\">" + value.toString().htmlspecials() + "</span>" + "<br/>";
		}
	});
	result += indentation + "} <br/>"
	return result;
}

public_format_xml = function(data, space) {
	var result = "";
	var width = "<span class=\"global_xml_space\"></span>";
	var indentation = space;
	space += width;
	result += indentation + "&lt;<span class=\"global_xml_tag\">" + data.prop("tagName").htmlspecials() + "</span>" + public_format_attribute(data) + "&gt;<br/>";
	$.each(data.children(), function() {
		if ($(this).children().length > 0) {
			result += public_format_xml($(this), space);
		} else {
			result += space + "&lt;<span class=\"global_xml_tag\">" + $(this).prop("tagName").htmlspecials() + "</span>" + public_format_attribute($(this)) + "&gt;<br/>";
			result += space + width + $(this).text().htmlspecials() + "<br/>";
			result += space + "&lt;<span class=\"global_xml_tag\">/" + $(this).prop("tagName").htmlspecials() + "</span>&gt;" + "<br/>";
		}
	});
	result += indentation + "&lt;<span class=\"global_xml_tag\">/" + data.prop("tagName").htmlspecials() + "</span>&gt;" + "<br/>";
	return result;
}

public_format_header = function(data) {
	return data.replaceAll("\n", "<br/>");
}

public_format_attribute = function(node) {
	var result = "";
	$.each(node[0].attributes, function() {
		result += " <span class=\"global_xml_attr\">" + this.name.toString().htmlspecials() + "</span>=" + "\"<span class=\"global_xml_value\">" + this.value.toString().htmlspecials() + "</span>\"";
	});
	return result;
}