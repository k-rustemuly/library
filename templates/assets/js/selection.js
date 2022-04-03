"use strict";

$("#kt_modal_add").on('shown.bs.modal', function (e) {

    $.get(tagListUrl, function (data) {
        var d = data.data;
        $('#tags').empty();
        for (var i = 0; i < d.length; i++) {
            $('#tags').append(new Option(d[i].name, d[i].id));
        }
        $('#tags').select2();
    });
    
});

function formSubmit() {
    var options = document.getElementById('tags').selectedOptions;
    document.getElementById('tags_output').value = '@'+Array.from(options).map(({ value }) => value).join('@')+'@';
    return true;
}