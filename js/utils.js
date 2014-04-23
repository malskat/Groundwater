function getQueryParams(qs) {
    qs = qs.split("+").join(" ");

    var params = {}, tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])]
            = decodeURIComponent(tokens[2]);
    }

    return params;
}

function beginDelete(deleteOptions) {
	var deleteHref = "location.href=\"../core/core_action.php?" + deleteOptions + "\"";
	$('#removeModalButton').attr('onclick', deleteHref);
	$('#removeModal').modal('show');
}
