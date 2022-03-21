"use strict";
var Api = function () {
    return {
        post: function (dest, data) {
            $.post(dest, data, function (data) {
                    alert("success" + data);
                })
                .done(function () {
                    alert("second success");
                })
                .fail(function () {
                    alert("error");
                })
                .always(function () {
                    alert("finished");
                });
        }
    }
}