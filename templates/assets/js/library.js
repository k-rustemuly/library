"use strict";


$('#isbn').maxlength({
    warningClass: "badge badge-warning",
    limitReachedClass: "badge badge-success"
});


$("#kt_modal_add").on('shown.bs.modal', function (e) {

    $.get(tagListUrl, function (data) {
        var d = data.data;
        $('#tags').empty();
        for (var i = 0; i < d.length; i++) {
            $('#tags').append(new Option(d[i].name, d[i].id));
        }
        $('#tags').select2();
    });
    $( "#isbn" ).change(function() {
        if($('#isbn').value().length == 12) {
            console.log("12");
        }else {
            console.log("not");
        }
    });
});


const t = document.getElementById("table");
const e = $(t).DataTable();
var r = document.getElementById("kt_filter_search");
r && r.addEventListener("keyup", (function (t) {
    e.search(t.target.value).draw()
}));

function formSubmit() {
    var options = document.getElementById('tags').selectedOptions;
    document.getElementById('tags_output').value = '@'+Array.from(options).map(({ value }) => value).join('@')+'@';
    return true;
}