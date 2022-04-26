// $(function () {
function ajaxRequest(url, data, dataType, method, callback) {
    if (
        method.toLowerCase() == "post" ||
        method.toLowerCase() == "put" ||
        method.toLowerCase() == "delete" ||
        method.toLowerCase() == "patch"
    ) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $("meta[name=csrf-token").attr("content"),
            },
        });
    }
    $.ajax({
        url: url,
        dataType: dataType,
        method: method,
        data: data,
        success: function (response) {
            callback(response);
        },
        fail: function (jqXHR, xhrStatus, errorThrown) {
            console.log(jqXHR, xhrStatus, errorThrown);
            if (jqXHR && jqXHR.status == 440) {
                // Session expired - do something here
                // alert("expired");
            } else if (jqXHR && jqXHR.status == 408) {
                // Request timeout - do something here
                // alert("timeout");
            } else {
                // Some other error - do something here
            }
        },
    });
}
// });
