/**
 * Created by Ali on 17/02/06.
 */

/**
 * Initializing tables
 * @param id : table id
 */
function makeDataTable(id) {
    var table = $('#'+id);

    var oTable = table.dataTable({
        // Internationalisation. For more info refer to http://datatables.net/manual/i18n
        "language": {
            "aria": {
                "sortAscending": "مرتب کردن صعودی ستون :",
                "sortDescending": "مرتب کردن نزولی ستون :"
            },
            "emptyTable": "اطلاعاتی برای نمایش وجود ندارد",
            "info": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
            "infoEmpty": "رکوردی در جدول یافت نشد",
            "infoFiltered": "(فیلترشده1 از _MAX_ رکورد)",
            "lengthMenu": "_MENU_ رکورد",
            "search": "جستجو:",
            "zeroRecords": "نتیجه ای برای جستجو یافت نشد"
        },

        "autoWidth": false,

        // Or you can use remote translation file
        //"language": {
        //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
        //},

        // setup buttons extentension: http://datatables.net/extensions/buttons/
        buttons:[
            {extend: 'print', className: 'btn m-btn--pill m-btn--air btn-outline-brand', exportOptions: {columns: ':visible'}},
            {extend: 'copy', className: 'btn m-btn--pill m-btn--air btn-outline-danger', exportOptions: {columns: ':visible'}},
            {extend: 'pdf', className: 'btn m-btn--pill m-btn--air btn-outline-success', exportOptions: {columns: ':visible'}},
            {extend: 'excel', className: 'btn m-btn--pill m-btn--air btn-outline-warning', exportOptions: {columns: ':visible'}},
            {extend: 'csv', className: 'btn m-btn--pill m-btn--air btn-outline-info', exportOptions: {columns: ':visible'}},
            // {extend: 'colvis', className: 'btn dark btn-outline', text: 'ستون ها'}
        ],

        // setup responsive extension: http://datatables.net/extensions/responsive/
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],

        order: [],

        // pagination control
        "lengthMenu": [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"] // change per page values here
        ],
        // set the initial value
        "pageLength": 10,
        "pagingType": 'bootstrap_extended', // pagination type

        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
        // So when dropdowns used the scrollable div should be removed.
        //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
    });
}

/**
 * Initializing tables
 * @param id : table id
 */

function makeDataTable_loadWithAjax(id, url, columns, dataFilter, ajaxData, dataSrc) {
    var table = $('#'+id);

    var dataTableOptions = {
        // Internationalisation. For more info refer to http://datatables.net/manual/i18n
        "language": {
            "aria": {
                "sortAscending": "مرتب کردن صعودی ستون :",
                "sortDescending": "مرتب کردن نزولی ستون :"
            },
            "emptyTable": "اطلاعاتی برای نمایش وجود ندارد",
            "info": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
            "infoEmpty": "رکوردی در جدول یافت نشد",
            "infoFiltered": "(فیلترشده1 از _MAX_ رکورد)",
            "lengthMenu": "_MENU_ رکورد",
            "search": "جستجو:",
            "zeroRecords": "نتیجه ای برای جستجو یافت نشد"
        },

        // Or you can use remote translation file
        //"language": {
        //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
        //},

        // setup buttons extentension: http://datatables.net/extensions/buttons/
        buttons:[
            {extend: 'print', className: 'btn m-btn--pill m-btn--air btn-outline-brand', exportOptions: {columns: ':visible'}},
            {extend: 'copy', className: 'btn m-btn--pill m-btn--air btn-outline-danger', exportOptions: {columns: ':visible'}},
            {extend: 'pdf', className: 'btn m-btn--pill m-btn--air btn-outline-success', exportOptions: {columns: ':visible'}},
            {extend: 'excel', className: 'btn m-btn--pill m-btn--air btn-outline-warning', exportOptions: {columns: ':visible'}},
            {extend: 'csv', className: 'btn m-btn--pill m-btn--air btn-outline-info', exportOptions: {columns: ':visible'}},
            // {extend: 'colvis', className: 'btn dark btn-outline', text: 'ستون ها'}
        ],

        // setup responsive extension: http://datatables.net/extensions/responsive/
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [
            {
                className: 'control',
                orderable: false,
                targets: 0
            }
        ],

        order: [],

        // pagination control
        "lengthMenu": [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"] // change per page values here
        ],
        // set the initial value
        "pageLength": 10,
        "pagingType": 'bootstrap_extended', // pagination type

        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
        // So when dropdowns used the scrollable div should be removed.
        //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

        "columns": columns
    };
    if (url !== null) {
        dataTableOptions.ajax = {
            "url": url,
            "data": ajaxData,
            'dataFilter': dataFilter,
            "dataSrc": dataSrc
        };
        dataTableOptions.processing = true;
        dataTableOptions.serverSide = true;
    }
    var dataTable = table.dataTable(dataTableOptions);
    return dataTable;
}

function getNextPageParam(start, length) {
    var page = (start / length) + 1;
    return page;
}
function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    for (var index in unindexed_array) {
        if (isNaN(index)) {
            continue;
        }
        var item = unindexed_array[index];
        if (item.name.indexOf("[]") !== -1) {
            if (typeof indexed_array[item.name] === 'undefined') {
                indexed_array[item.name] = [];
            }
            indexed_array[item.name].push(item.value);
        } else {
            indexed_array[item.name] = item.value;
        }
    }

    // $.map(unindexed_array, function(n, i){
    //     indexed_array[n['name']] = n['value'];
    // });

    return indexed_array;
}

//dataTable without button
/**
 * Initializing tables
 * @param id : table id
 */
function makeDataTableWithoutButton(id ) {
    var table = $('#'+id);

    var oTable = table.dataTable({
        // Internationalisation. For more info refer to http://datatables.net/manual/i18n
        "language": {
            "aria": {
                "sortAscending": "مرتب کردن صعودی ستون :",
                "sortDescending": "مرتب کردن نزولی ستون :"
            },
            "emptyTable": "اطلاعاتی برای نمایش وجود ندارد",
            "info": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
            "infoEmpty": "رکوردی در جدول یافت نشد",
            "infoFiltered": "(فیلترشده1 از _MAX_ رکورد)",
            "lengthMenu": "_MENU_ رکورد",
            "search": "جستجو:",
            "zeroRecords": "نتیجه ای برای جستجو یافت نشد"
        },
        // Or you can use remote translation file
        //"language": {
        //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
        //},

        // setup buttons extentension: http://datatables.net/extensions/buttons/
        buttons: [
            // { extend: 'print', className: 'btn dark btn-outline' },
            // { extend: 'copy', className: 'btn red btn-outline' },
            // { extend: 'pdf', className: 'btn green btn-outline' },
            // { extend: 'excel', className: 'btn yellow btn-outline ' },
            // { extend: 'csv', className: 'btn purple btn-outline ' },
            // { extend: 'colvis', className: 'btn dark btn-outline', text: 'ستون ها'}
        ],

        // setup responsive extension: http://datatables.net/extensions/responsive/
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],

        order: [],

        // pagination control
        "lengthMenu": [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"] // change per page values here
        ],
        // set the initial value
        "pageLength": 10,
        "pagingType": 'bootstrap_extended', // pagination type

        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
        // So when dropdowns used the scrollable div should be removed.
        //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
    });
}

//

function makeButtonDataTable(id) {

    var table = $('#'+id);

    table.dataTable({

        // Internationalisation. For more info refer to http://datatables.net/manual/i18n
        "language": {
            "aria": {
                "sortAscending": ": مرتب سازی صعودی ستون",
                "sortDescending": ": مرتب سازی نزولی ستون"
            },
            "emptyTable": "داده ای برای نمایش وجود ندارد",
            "info": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
            "infoEmpty": "رکوردی پیدا نشد",
            "infoFiltered": "(filtered1 میان از _MAX_ رکورد)",
            "lengthMenu": "_MENU_ رکورد",
            "search": "جستجو:",
            "zeroRecords": "داده ای با نتیجه مطابقت ندارد"
        },

        // Or you can use remote translation file
        //"language": {
        //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
        //},


        buttons: [
            { extend: 'print', className: 'btn dark btn-outline' , },
        ],

        // setup responsive extension: http://datatables.net/extensions/responsive/
        responsive: true,

        //"ordering": false, disable column ordering
        //"paging": false, disable pagination

        "order": [
            [0, 'asc']
        ],

        "lengthMenu": [
            [20 , 40, -1],
            [20, 40 , "All"] // change per page values here
        ],
        // set the initial value
        "pageLength": 20,

        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
        // So when dropdowns used the scrollable div should be removed.
        //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
    });
}


//dataTable for SMS panel
var TableDatatablesManaged = function () {

    var initTable = function () {

        var table = $('#sms_table');

        // begin: third table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": "مرتب کردن صعودی ستون :",
                    "sortDescending": "مرتب کردن نزولی ستون :"
                },
                "info": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
                "infoEmpty": "رکوردی در جدول یافت نشد",
                "infoFiltered": "(فیلترشده1 از _MAX_ رکورد)",
                "lengthMenu": "_MENU_ رکورد",
                "search": "جستجو:",
                "zeroRecords": "نتیجه ای برای جستجو یافت نشد",
                "paginate": {
                    "previous":"قبلی",
                    "next": "بعدی",
                    "last": "آخرین",
                    "first": "اولی"
                }
            },
            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
            // So when dropdowns used the scrollable div should be removed.
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [5,10, 15, 20,30, -1],
                [5,10, 15, 20,30, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,
            "columnDefs": [{  // set default column settings
                'className': 'control',
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [

            ], // set first column as a default sort by asc
            stateSave: true
        });

        var tableWrapper = jQuery('#sms_table_wrapper');
        var allPages = table.fnGetNodes();


        // table.find('.group-checkable').change(function () {
        //     var set = jQuery(this).attr("data-set");
        //     var checked = jQuery(this).is(":checked");
        //     jQuery(set).each(function () {
        //         if (checked) {
        //             $(this).prop("checked", true);
        //             user_id.push($(this).closest('tr').attr('id'));
        //         } else {
        //             $(this).prop("checked", false);
        //             user_id.pop();
        //         }
        //     });
        // });


        $('body').on('click', '.group-checkable', function () {
            if (jQuery(this).is(":checked")) {
                user_id = [];
                fatherNumbers = 0;
                motherNumbers = 0;
                $('input[type="checkbox"]', allPages).prop('checked', true);
                for(var i = 0; i < allPages.length; i++) {
                    user_id.push(allPages[i].id);
                    if($('#fatherNumbers'+allPages[i].id).val()){
                        fatherNumbers += parseInt($('#fatherNumbers'+allPages[i].id).val());
                    }
                    if($('#matherNumbers'+allPages[i].id).val()){
                        motherNumbers += parseInt($('#matherNumbers'+allPages[i].id).val());
                    }
                }
            }
            else {
                $('input[type="checkbox"]', allPages).prop('checked', false);
                user_id = [];
                fatherNumbers = 0;
                motherNumbers = 0;
            }
        })
    };


    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

            initTable();
        }

    };

}();
// if (typeof App === 'undefined' || App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
        $("#sms_table > tbody .dataTables_empty").text("برای نمایش اطلاعات ابتدا فیلتر کنید").addClass("font-red bold");
    });
// }

