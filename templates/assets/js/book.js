"use strict";


$('#isbn').maxlength({
    warningClass: "badge badge-warning",
    limitReachedClass: "badge badge-success"
});


$('#description').maxlength({
    warningClass: "badge badge-primary",
    limitReachedClass: "badge badge-success"
});

var inputElm = document.querySelector('#authors');

$("#kt_modal_add").on('shown.bs.modal', function (e) {
    tagifyRefresh();
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
});

function tagTemplate(tagData) {
    return `
        <tag title="${(tagData.title || tagData.name)}"
                contenteditable='false'
                spellcheck='false'
                tabIndex="-1"
                class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
                ${this.getAttributes(tagData)}>
            <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div class="d-flex align-items-center">
                <div class='tagify__tag__avatar-wrap ps-0'>
                    <img onerror="this.style.visibility='hidden'" class="rounded-circle w-25px me-2" src="${tagData.avatar}">
                </div>
                <span class='tagify__tag-text'>${tagData.name}</span>
            </div>
        </tag>
    `
}

function suggestionItemTemplate(tagData) {
    return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item d-flex align-items-center ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            ${tagData.avatar ? `
                    <div class='tagify__dropdown__item__avatar-wrap me-2'>
                        <img onerror="this.style.visibility='hidden'"  class="rounded-circle w-50px me-2" src="${tagData.avatar}">
                    </div>` : ''
                }
            <div class="d-flex flex-column">
                <strong>${tagData.name}</strong>
            </div>
        </div>
    `
}

var tagify = new Tagify(inputElm, {
    tagTextProp: 'name',
    enforceWhitelist: true,
    deferredWhitelist: true, // will load whitelist later
    dropdown: {
        closeOnSelect: false,
        enabled: 1,
        classname: 'users-list',
        searchKeys: ['name']
    },
    templates: {
        tag: tagTemplate,
        dropdownItem: suggestionItemTemplate
    },
    whitelist: [
    ]
})


async function tagifyRefresh() {
    tagify.settings.whitelist.length = 0;
    tagify.loading(true).dropdown.hide.call(tagify);
    $.get(authorList, function (data) {
        var newWhitelist = data.data;
        console.log(newWhitelist);
        tagify.settings.whitelist.push(newWhitelist);
        tagify.loading(false);
    });

}


const t = document.getElementById("table");
const e = $(t).DataTable();
var r = document.getElementById("kt_filter_search");
r && r.addEventListener("keyup", (function (t) {
    e.search(t.target.value).draw()
}))