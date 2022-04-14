"use strict";


$('#isbn').maxlength({
    warningClass: "badge badge-warning",
    limitReachedClass: "badge badge-success"
});


$("#kt_modal_add").on('shown.bs.modal', function (e) {

    $("#aboutBook").hide();
    $.get(tagListUrl, function (data) {
        var d = data.data;
        $('#tags').empty();
        for (var i = 0; i < d.length; i++) {
            $('#tags').append(new Option(d[i].name, d[i].id));
        }
        $('#tags').select2();
    });
    $( "#isbn" ).on('input', function() {
        if($('#isbn').val().length == 13) {
            var isbn = $('#isbn').val();
            $.get(bookSearchUrl, {isbn: isbn}, function (data) {
                var d = data.data;
                $('#abImage').attr( "src", d.image );
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

function formSubmitEdit() {
    var options = document.getElementById('editTags').selectedOptions;
    document.getElementById('EditTags_output').value = '@'+Array.from(options).map(({ value }) => value).join('@')+'@';
    return true;
}

//librarySearchUrl

$(document).on('click', ".library-edit", function () {
    var id = $(this).attr('id');
    $("i", this).removeClass("la-pencil-alt");
    $("i", this).addClass('la-spinner');
    var f = $("i", this);
    $.get(bookSearchUrl, {id: id}, function (data) {
        var d = data.data;
        $('#editAbImage').attr( "src", d.image );
        $('#editAbName').text(d.name);
        $('#editAbYear').text(d.published_year);
        $("#editAboutBook").show();
    });
    $.get(tagListUrl, function (data) {
        var d = data.data;
        $('#editTags').empty();
        for (var i = 0; i < d.length; i++) {
            $('#editTags').append(new Option(d[i].name, d[i].id));
        }
        $('#editTags').select2();
        loadData(id);
        f.removeClass("la-spinner");
        f.addClass('la-pencil-alt');
    });
});
function loadData(id) {
    $.get(librarySearchUrl, {id: id}, function (data) {
        var d = data.data;
        $("#editId").val(id);
        $("#editIsbn").val(d.isbn);
        $("#editCount").val(d.count);
        var values=d.tags;
        $.each(values.split("@"), function(i,e){
            if(e > 0)
            $("#editTags option[value='" + e + "']").prop("selected", true);
        });
        $('#editTags').select2();
        $("#kt_modal_edit").modal('show');

    });
}