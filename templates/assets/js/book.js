"use strict";


$('#isbn').maxlength({
    warningClass: "badge badge-warning",
    limitReachedClass: "badge badge-success"
});


$('#description').maxlength({
    warningClass: "badge badge-primary",
    limitReachedClass: "badge badge-success"
});

$("#kt_modal_add").on('shown.bs.modal', function (e) {

    $.get(languageUrl, function (data) {
        var languages = data.data;
        $('#language_code').empty();
        for (var i = 0; i < languages.length; i++) {
            $('#language_code').append(new Option(languages[i].name, languages[i].code));
        }
        $('#language_code').select2();
    });
    $.get(publisherUrl, function (data) {
        var d = data.data;
        $('#publisher').empty();
        for (var i = 0; i < d.length; i++) {
            $('#publisher').append(new Option(d[i].name, d[i].id));
        }
        $('#publisher').select2();
    });
    $.get(seriesUrl, function (data) {
        var d = data.data;
        $('#series').empty();
        for (var i = 0; i < d.length; i++) {
            $('#series').append(new Option(d[i].name, d[i].id));
        }
        $('#series').select2();
    });
    $.get(authorList, function (data) {
        var d = data.data;
        $('#authors').empty();
        for (var i = 0; i < d.length; i++) {
            $('#authors').append(new Option(d[i].name, d[i].id));
        }
        $('#authors').select2();
    });
    
});


const t = document.getElementById("table");
const e = $(t).DataTable();
var r = document.getElementById("kt_filter_search");
r && r.addEventListener("keyup", (function (t) {
    e.search(t.target.value).draw()
}));

function formSubmit() {
    var options = document.getElementById('authors').selectedOptions;
    document.getElementById('authors_output').value = '@'+Array.from(options).map(({ value }) => value).join('@')+'@';
    return true;
}
$(".book-edit").on('click', function (e) {
    var id = $(this).attr('id');
    $("i", this).removeClass("la-pencil-alt");
    $("i", this).addClass('la-spinner');
    $.get(bookSearchUrl, {id: id}, function (data) {
        var d = data.data;
        $("#book_edit").modal('show');
        $("i", this).removeClass("la-spinner");
        $("i", this).addClass('la-pencil-alt');
        
    });
    
    //alert(id);
});
//<