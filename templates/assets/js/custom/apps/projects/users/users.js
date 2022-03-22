"use strict";
var KTProjectUsers = {
    init: function () {
        ! function () {
            const t = document.getElementById("kt_project_users_table");
            if (!t) return;
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
        }()
    }
};
KTUtil.onDOMContentLoaded((function () {
    KTProjectUsers.init()
}));