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
var usersList = [
    { value: 1, name: 'Emma Smith', avatar: 'avatars/300-6.jpg' },
    { value: 2, name: 'Max Smith', avatar: 'avatars/300-1.jpg' },
    { value: 3, name: 'Sean Bean', avatar: 'avatars/300-5.jpg' },
    { value: 4, name: 'Brian Cox', avatar: 'avatars/300-25.jpg' },
    { value: 5, name: 'Francis Mitcham', avatar: 'avatars/300-9.jpg' },
    { value: 6, name: 'Dan Wilson', avatar: 'avatars/300-23.jpg' },
    { value: 7, name: 'Ana Crown', avatar: 'avatars/300-12.jpg'},
    { value: 8, name: 'John Miller', avatar: 'avatars/300-13.jpg'}
];
$( "#kt_modal_add" ).on('shown.bs.modal', function (e) {
    $.get( languageUrl, function( data ) {
        var languages = data.data;
        for ( var i = 0; i < languages.length; i++) {
            $('#language_code').append(new Option(languages[i].code, languages[i].name));
        }
        $('#language_code').select2();
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
                    <img onerror="this.style.visibility='hidden'" class="rounded-circle w-25px me-2" src="/assets/media/${tagData.avatar}">
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
                        <img onerror="this.style.visibility='hidden'"  class="rounded-circle w-50px me-2" src="/assets/media/${tagData.avatar}">
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
    skipInvalid: true,
    dropdown: {
        closeOnSelect: false,
        enabled: 0,
        classname: 'users-list',
        searchKeys: ['name']
    },
    templates: {
        tag: tagTemplate,
        dropdownItem: suggestionItemTemplate
    },
    whitelist: usersList
})

tagify.on('dropdown:show dropdown:updated', onDropdownShow)
tagify.on('dropdown:select', onSelectSuggestion)

var addAllSuggestionsElm;

function onDropdownShow(e) {
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;

    if (tagify.suggestedListItems.length > 1) {
        addAllSuggestionsElm = getAddAllSuggestionsElm();

        dropdownContentElm.insertBefore(addAllSuggestionsElm, dropdownContentElm.firstChild)
    }
}

function onSelectSuggestion(e) {
    if (e.detail.elm == addAllSuggestionsElm)
        tagify.dropdown.selectAll.call(tagify);
}

function getAddAllSuggestionsElm() {
    return tagify.parseTemplate('dropdownItem', [{
        class: "addAll",
        name: "Add all",
        value: tagify.settings.whitelist.reduce(function (remainingSuggestions, item) {
            return tagify.isTagDuplicate(item.value) ? remainingSuggestions : remainingSuggestions + 1
        }, 0) + " Members"
    }]
    )
}



function getWhitelistFromServer(){

}

const t = document.getElementById("table");
const e = $(t).DataTable();
var r = document.getElementById("kt_filter_search");
r && r.addEventListener("keyup", (function (t) {
    e.search(t.target.value).draw()
}))

