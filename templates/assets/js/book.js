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

function formSubmitEdit() {
    var options = document.getElementById('editAuthors').selectedOptions;
    document.getElementById('editAuthors_output').value = '@'+Array.from(options).map(({ value }) => value).join('@')+'@';
    return true;
}
$(document).on('click', ".book-edit", function () {
    var id = $(this).attr('id');
    $("i", this).removeClass("la-pencil-alt");
    $("i", this).addClass('la-spinner');
    var f = $("i", this);
    var loaded = 0;
    $.get(languageUrl, function (data) {
        var languages = data.data;
        $('#editLanguageCode').empty();
        for (var i = 0; i < languages.length; i++) {
            $('#editLanguageCode').append(new Option(languages[i].name, languages[i].code));
        }
        $('#editLanguageCode').select2();
        loaded++;
        if(loaded == 4) {
            loadData(id);
            f.removeClass("la-spinner");
            f.addClass('la-pencil-alt');
        }

    });
    $.get(publisherUrl, function (data) {
        var d = data.data;
        $('#editPublisher').empty();
        for (var i = 0; i < d.length; i++) {
            $('#editPublisher').append(new Option(d[i].name, d[i].id));
        }
        $('#editPublisher').select2();
        loaded++;
        if(loaded == 4) {
            loadData(id);
            f.removeClass("la-spinner");
            f.addClass('la-pencil-alt');
        }

    });
    $.get(seriesUrl, function (data) {
        var d = data.data;
        $('#editSeries').empty();
        for (var i = 0; i < d.length; i++) {
            $('#editSeries').append(new Option(d[i].name, d[i].id));
        }
        $('#editSeries').select2();
        loaded++;
        if(loaded == 4) {
            loadData(id);
            f.removeClass("la-spinner");
            f.addClass('la-pencil-alt');
        }
    });
    $.get(authorList, function (data) {
        var d = data.data;
        $('#editAuthors').empty();
        for (var i = 0; i < d.length; i++) {
            $('#editAuthors').append(new Option(d[i].name, d[i].id));
        }
        $('#editAuthors').select2();
        loaded++;
        if(loaded == 4) {
            loadData(id);
            f.removeClass("la-spinner");
            f.addClass('la-pencil-alt');
        }
    });
});
function loadData(id) {
    $.get(bookSearchUrl, {id: id}, function (data) {
        var d = data.data;
        $("#editId").val(id);
        $("#editIsbn").val(d.isbn);
        $("#editName").val(d.name);
        $("#editImage").css("background-image", "url(" + d.image + ")");
        $("#editPageCount").val(d.page_count);
        $('#editPubYear option[value="'+d.published_year+'"]').prop('selected', true);
        $('#editPubYear').select2();
        $('#editLanguageCode option[value="'+d.language_code+'"]').prop('selected', true);
        $('#editPublisher option[value="'+d.publisher_id+'"]').prop('selected', true);
        $('#editSeries option[value="'+d.publisher_id+'"]').prop('selected', true);
        $("#editDescription").val(d.description);
        var values=d.author_ids;
        $.each(values.split("@"), function(i,e){
            if(e > 0)
            $("#editAuthors option[value='" + e + "']").prop("selected", true);
        });
        $('#editAuthors').select2();
        $("#book_edit").modal('show');

    });
}