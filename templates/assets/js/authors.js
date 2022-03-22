"use strict";
var KTDatatablesServerSide = function () {
    var table;
    var dt;
    var initDatatable = function () {
        dt = $("#kt_datatable_example_1").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[1, 'desc']],
            stateSave: true,
            ajax: {
                url: "https://preview.keenthemes.com/api/datatables.php",
            },
            columns: [
                { data: 'Name' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    render: function (data) {
                        return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="${data}" />
                            </div>`;
                    }
                }
            ],
        });
        table = dt.$;
        dt.on('draw', function () {
            toggleToolbars();
            KTMenu.createInstances();
        });
    }
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }
    var toggleToolbars = function () {
        const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
        toolbarBase.classList.remove('d-none');
    }
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
        }
    }
}();
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});

