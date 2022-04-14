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
    $( "#isbn" ).on('input', function() {
        if($('#isbn').val().length == 12) {
            var isbn = $('#isbn').val();
            $.get(bookSearchUrl, {isbn: isbn}, function (data) {
                var d = data.data;
                $('#abImage').attr( "src" ).val(d.image);
                $('#abName').text(d.name);
                $('#abYear').text(d.published_year);
            });
            $("#aboutBook").show();
        }else {
            $("#aboutBook").hide();
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