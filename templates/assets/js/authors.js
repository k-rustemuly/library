"use strict";
const t = document.getElementById("authors");
const e = $(t).DataTable({
    info: !1,
    order: [],
    columnDefs: [{
        targets: 4,
        orderable: !1
    }]
});
var r = document.getElementById("kt_filter_search");
r && r.addEventListener("keyup", (function (t) {
    e.search(t.target.value).draw()
}))