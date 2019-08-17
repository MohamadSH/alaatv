
convertElementContentToJalali('.needConvertToJalali');
function convertElementContentToJalali(elementQuerySelect) {
    $(elementQuerySelect).each(function () {
        var content = $(this).html().trim();
        if (content === '') {
            return true;
        }
        var unixDate = new Date(content).getTime();
        var jalaliDateObject = new persianDate(unixDate);
        var jalaliDateTime = jalaliDateObject.format("YYYY/M/D HH:m:s");
        $(this).html(jalaliDateTime);
    });
}

$('select.select2')
    .select2({closeOnSelect: true})
    .on('select2:select', function (event) {
        $('select.select2').select2("close");
    })
    .on('select2:close', function (event) {
        $('select.select2').select2('destroy');
        $('select.select2').select2({closeOnSelect: true});
        $('select.select2').select2("close");
        $('select.select2').select2("close");
    });


var TableDatatablesEditable = function () {

    var handleTable = function () {

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            if (aData.length > 2) {
                var i;
                for (i = 0; i < aData.length - 2; i++) {
                    if (aData[i].includes("ندارد"))
                        aData[i] = "";
                    if (i <= 1) {
                        jqTds[i].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[i] + '" disabled>';
                    } else {
                        jqTds[i].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[i] + '">';
                    }

                }
                jqTds[i].innerHTML = '<a class="edit"  href="">ذخیره</a>';
                jqTds[++i].innerHTML = '<a class="cancel" href="">لغو</a>';
            }
        }

        function saveRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            // var newData = [jqInputs.context.id];
            var newData = [];
            if (jqInputs.length > 0) {
                let i = 0;
                for (; i < jqInputs.length; i++) {
                    newData.push(jqInputs[i].value);
                    oTable.fnUpdate(jqInputs[i].value, nRow, i, false);
                }
                oTable.fnUpdate('<a class="edit" href="javascript:;"><i class="fa fa-pencil-square fa-lg font-green" aria-hidden="true"></i></a>', nRow, i, false);
                oTable.fnUpdate('<a class="deleteTransaction"  data-target="#deleteTransactionConfirmationModal" data-toggle="modal"><i class="fa fa-trash fa-lg m--font-danger" aria-hidden="true"></i></a>', nRow, ++i, false);
            }
            oTable.fnDraw();
            updateRow(newData);
        }

        function cancelEditRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
            oTable.fnUpdate('<a class="edit" href="">اصلاح</a>', nRow, 4, false);
            oTable.fnDraw();
        }

        var table = $('#sample_editable_1');
        var table_totalTransaction = $('#sample_editable_2');

        let datatableConfig = {

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
            // So when dropdowns used the scrollable div should be removed.
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // set the initial value
            "pageLength": 5,

            "language": {
                "lengthMenu": " _MENU_ رکوردها"
            },
            "columnDefs": [{ // set default column settings
                'orderable': true,
                'targets': [0]
            }, {
                "searchable": true,
                "targets": [0]
            }],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        };
        var oTable = table.dataTable(datatableConfig);
        var oTable_totalTransaction = table_totalTransaction.dataTable(datatableConfig);

        var nEditing = null;
        var nNew = false;

        var nEditing_totalTransaction = null;
        var nNew_totalTransaction = false;

        $('#sample_editable_1_new').click(function (e) {
            e.preventDefault();

            if (nNew && nEditing) {
                if (confirm("سطر قبلی ذخیره نشده است ، آیا می خواهید آن را ذخیره کنید؟")) {
                    saveRow(oTable, nEditing); // save
                    $(nEditing).find("td:first").html("بدون عنوان");
                    nEditing = null;
                    nNew = false;

                } else {
                    oTable.fnDeleteRow(nEditing); // cancel
                    nEditing = null;
                    nNew = false;

                    return;
                }
            }

            var aiNew = oTable.fnAddData(['', '', '', '', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("آیا از حذف سطر مطمئن هستید ?") == false) {
                return;
            }

            var nRow = $(this).parents('tr')[0];
            oTable.fnDeleteRow(nRow);
            alert("سطر حذف شد ! حال باید آن را از پایگاه داده حذف کنید");
        });

        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();
            nNew = false;

            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == "ذخیره") {
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);
                nEditing = null;
//                        alert("اصلاح انجام شد! حال باید پایگاه داده را اصلاح کنید");
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });

        table_totalTransaction.on('click', '.delete', function (e) {

            e.preventDefault();

            if (confirm("آیا از حذف سطر مطمئن هستید ?") == false) {
                return;
            }

            var nRow = $(this).parents('tr')[0];
            oTable_totalTransaction.fnDeleteRow(nRow);
            alert("سطر حذف شد ! حال باید آن را از پایگاه داده حذف کنید");
        });

    };

    return {

        //main function to initiate the module
        init: function () {
            handleTable();
        }

    };

}();
var FormRepeater = function () {

    return {
        //main function to initiate the module
        init: function () {
            $('.mt-repeater').each(function () {
                $(this).repeater({
                    show: function () {
                        var elements = $(this).find(':input');

                        var matches = elements.attr("name").match(/\[[^\]]+\]/g);
                        if (matches === null) {
                            return true;
                        }
                        matches = matches[0].match(/(\d+)/);
                        var id = matches[0];

                        $.each(elements, function (index, value) {
                            var matches = $(value).attr("name").match(/\[[^\]]+\]/g);
                            if (matches === null) {
                                return true;
                            }
                            var name = matches[matches.length - 1].replace(/\[|\]/g, '');
                            $(value).attr("id", name + "_" + id);
                            $(value).attr("data-role", id);
                        });

                        $(this).slideDown();
                    },

                    hide: function (deleteElement) {
                        if (confirm('آیا مطمئن هستید؟')) {
                            $(this).slideUp(deleteElement);
                        }
                    },

                    ready: function (setIndexes) {
                        var elements = $(".mt-repeater-item.mt-overflow").find(':input');

                        var matches = elements.attr("name").match(/\[[^\]]+\]/g);
                        if (matches === null) {
                            return true;
                        }
                        matches = matches[0].match(/(\d+)/);
                        var id = matches[0];


                        $.each(elements, function (index, value) {
                            var matches = $(value).attr("name").match(/\[[^\]]+\]/g);
                            if (matches === null) {
                                return true;
                            }
                            var name = matches[matches.length - 1].replace(/\[|\]/g, '');
                            $(value).attr("id", name + "_" + id);
                            $(value).attr("data-role", id);
                        });
                    }
                });
            });
        }

    };

}();

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': window.Laravel.csrfToken,
        }
    });
});

function paymentMethodState(element) {
    if (element.val() == "online") {
        $('input[name="referenceNumber"]').attr('disabled', true);
        $('input[name="authority"]').attr('disabled', false);
        $('input[name="traceNumber"]').attr('disabled', true);
        $('input[name="paycheckNumber"]').attr('disabled', true);
    } else if (element.val() == "cash") {
        $('input[name="referenceNumber"]').attr('disabled', true);
        $('input[name="authority"]').attr('disabled', true);
        $('input[name="traceNumber"]').attr('disabled', true);
        $('input[name="paycheckNumber"]').attr('disabled', true);
    } else if (element.val() == "paycheck") {
        $('input[name="referenceNumber"]').attr('disabled', true);
        $('input[name="authority"]').attr('disabled', true);
        $('input[name="traceNumber"]').attr('disabled', true);
        $('input[name="paycheckNumber"]').attr('disabled', false);
    } else {
        $('input[name="referenceNumber"]').attr('disabled', false);
        $('input[name="authority"]').attr('disabled', true);
        $('input[name="traceNumber"]').attr('disabled', false);
        $('input[name="paycheckNumber"]').attr('disabled', true);
    }
}

function transactionStatusState(element) {
    if (element.val() == TRANSACTION_STATUS_UNPAID) {
        $('#transactionDeadlineAt').attr('disabled', false);
        $('#transactionDeadlineAtAlt').attr('disabled', false);
        $('#transactionCompletedAt').attr('disabled', true);
        $('#transactionCompletedAtAlt').attr('disabled', true);
        $('#paymentMethodName').attr('disabled', true);
        $('input[name="referenceNumber"]').attr('disabled', true);
        $('input[name="authority"]').attr('disabled', true);
        $('input[name="traceNumber"]').attr('disabled', true);
        $('input[name="paycheckNumber"]').attr('disabled', true);
    } else {
        $('#transactionDeadlineAt').attr('disabled', true);
        $('#transactionDeadlineAtAlt').attr('disabled', true);
        $('#transactionCompletedAt').attr('disabled', false);
        $('#transactionCompletedAtAlt').attr('disabled', false);
        $('#paymentMethodName').attr('disabled', false);
        // paymentMethodState($('#paymentMethodName'));
        $('input[name="referenceNumber"]').attr('disabled', false);
        $('input[name="authority"]').attr('disabled', false);
        $('input[name="traceNumber"]').attr('disabled', false);
        $('input[name="paycheckNumber"]').attr('disabled', false);
    }
}

jQuery(document).ready(function () {
    TableDatatablesEditable.init();
    FormRepeater.init();
    SweetAlert.init();

    $("#transactionDeadlineAt").persianDatepicker({
        altField: '#transactionDeadlineAtAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY-MM-DD',
        altFieldFormatter: function (unixDate) {
            // var d = new Date(unixDate).toISOString();
            let targetDatetime = new Date(unixDate);
            let formatted_date = targetDatetime.getFullYear() + "-" + (targetDatetime.getMonth() + 1) + "-" + targetDatetime.getDate();
            return formatted_date;
        }
    });

    $("#transactionCompletedAt").persianDatepicker({
        altField: '#transactionCompletedAtAlt',
        altFormat: "YYYY-MM-DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function (unixDate) {
            // var d = new Date(unixDate).toISOString();
            let targetDatetime = new Date(unixDate);
            let formatted_date = targetDatetime.getFullYear() + "-" + (targetDatetime.getMonth() + 1) + "-" + targetDatetime.getDate();
            return formatted_date;
        }
    });

    // paymentMethodState($('#paymentMethodName'));
    transactionStatusState($("#transactionstatus_id"));

});

$(document).on("change", "#enableBonPlus", function () {
    if (this.checked) {
        $('input[name="bonPlus"]').attr('disabled', false);
    } else {
        $('input[name="bonPlus"]').attr('disabled', true);
    }
});

$(document).on("click", ".deleteTransaction", function () {
    var transaction_id = $(this).closest('tr').attr('id');
    $("input[name=transaction_id]").val(transaction_id);
    $("#deleteTransactionFullName").text($("#transactionFullName_" + transaction_id).text());
});

function removeTransaction() {
    var transaction_id = $("input[name=transaction_id]").val();
    $.ajax({
        type: 'POST',
        url: '/transaction/' + transaction_id,
        data: {_method: 'delete'},
        success: function (result) {
            location.reload();
        },
        error: function (result) {
        }
    });
}

function updateRow(newData) {
    var transaction_id = $("input[name=transaction_id]").val();
    $.ajax({
        type: 'PUT',
        url: '/transaction/' + newData[0],
        data: {
            cost: newData[5],
            transactionID: newData[6],
            referenceNumber: newData[7],
            traceNumber: newData[8],
            paycheckNumber: newData[9],
            managerComment: newData[10]
        },
        success: function (result) {
            $(".removeTransactionSuccess").removeClass("d-none");
            location.reload();
        },
        error: function (result) {
            $(".removeTransactionError").removeClass("d-none");
            $(".removeTransactionError > span").html(result.responseText);
        }
    });
}

$('#changeProduct').click(function () {
    if ($('#changeProduct').prop('checked') == true) {
        $('#productSelect').attr('disabled', false);
    } else {
        $('#productSelect').attr('disabled', true);
    }
});

$(document).on("change", ".paymentMethodName", function () {

    // paymentMethodState($(this));
});

$(document).on("change", "#transactionstatus_id", function () {

    transactionStatusState($(this));
});

$(document).on("click", ".removeOrderproduct", function () {
    let orderProductId = $(this).data('order-product-id');
    $('input[type="hidden"][name="orderProductIdForRemove"]').val(orderProductId);
});

$(document).on("click", ".btnRemoveOrderproductInModal", function () {
    let orderProductId = $('input[type="hidden"][name="orderProductIdForRemove"]').val();
    $.ajax({
        type: "DELETE",
        url: '/orderproduct/' + orderProductId,
        data: {_token: csrf_token},
        statusCode: {
            200: function (response) {
                location.reload();
            },
            403: function (response) {
                window.location.replace("/403");
            },
            401: function (response) {
                window.location.replace("/403");
            },
            405: function (response) {
                location.reload();
            },
            404: function (response) {
                window.location.replace("/404");
            },
            //The status for when there is error php code
            503: function (response) {
                toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
            }
        }
    });
});

$(document).on("click", ".recycleOrderproduct", function () {
    let orderProductId = $(this).data('order-product-id');
    $('input[type="hidden"][name="orderProductIdForRecycle"]').val(orderProductId);
    let actionUrl = $(this).data('action');
    $('input[type="hidden"][name="orderProductRestoreActionUrl"]').val(actionUrl);
});

$(document).on("click", ".btnRecycleOrderproductInModal", function () {
    let orderProductId = $('input[type="hidden"][name="orderProductIdForRecycle"]').val();
    let actionUrl = $('input[type="hidden"][name="orderProductRestoreActionUrl"]').val();
    $.ajax({
        type: "POST",
        url: actionUrl,
        data: {_token: csrf_token , orderproductId:orderProductId},
        statusCode: {
            200: function (response) {
                if(response.error != undefined && response.error != null){
                    if(response.error.code == 503){
                        toastr["error"]("خطای غیر منتظره", "پیام سیستم");
                    }else if(response.error.code == 404){
                        toastr["error"]("آیتم مورد نظر یافت نشد", "پیام سیستم");
                    }
                }else{
                    location.reload();
                }
            },
            403: function (response) {
                toastr["error"]("شما اجازه این کار را ندارید", "پیام سیستم");
            },
            404: function (response) {
                toastr["error"]("درخواست مورد نظر یافت نشد", "پیام سیستم");
            },
            //The status for when there is error php code
            500: function (response) {
                toastr["error"]("خطای کد!", "پیام سیستم");
            }
        }
    });
});

var TableDatatablesManaged = function () {

    var initTable1 = function () {

        var table = $('#sample_1');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "داده ای برای نمایش وجود ندارد",
                "info": "نمایش _START_ تا    _END_ از _TOTAL_ داده",
                "infoEmpty": "داده ای یافت نشد",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "نمایش _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous": "Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },
            "paging": false,
            "searching": false,
            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
            // So when dropdowns used the scrollable div should be removed.
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 5,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [0]
                },
                {
                    "searchable": false,
                    "targets": [0]
                },
                {
                    "className": "dt-right",
                    //"targets": [2]
                }
            ],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#sample_1_wrapper');

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).prop("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
        });

        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
            var ck_box = $('.checkboxes:checked').length;
            if (ck_box == 0) {
                $("#detachOrderproducts").prop('disabled', true);
                $("#orderproductExchangeButton").prop('disabled', true);
            } else {
                $("#detachOrderproducts").prop('disabled', false);
                $("#orderproductExchangeButton").prop('disabled', false);
            }

        });
    };

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

            initTable1();
        }

    };

}();

var detachOrderproductAjax;
var SweetAlert = function () {

    return {
        //main function to initiate the module
        init: function () {
            $('.mt-sweetalert').each(function () {
                var sa_title = $(this).data('title');
                var sa_message = $(this).data('message');
                var sa_type = $(this).data('type');
                var sa_allowOutsideClick = $(this).data('allow-outside-click');
                var sa_showConfirmButton = $(this).data('show-confirm-button');
                var sa_showCancelButton = $(this).data('show-cancel-button');
                var sa_closeOnConfirm = $(this).data('close-on-confirm');
                var sa_closeOnCancel = $(this).data('close-on-cancel');
                var sa_confirmButtonText = $(this).data('confirm-button-text');
                var sa_cancelButtonText = $(this).data('cancel-button-text');
                var sa_popupTitleSuccess = $(this).data('popup-title-success');
                var sa_popupMessageSuccess = $(this).data('popup-message-success');
                var sa_popupTitleCancel = $(this).data('popup-title-cancel');
                var sa_popupMessageCancel = $(this).data('popup-message-cancel');
                var sa_confirmButtonClass = $(this).data('confirm-button-class');
                var sa_cancelButtonClass = $(this).data('cancel-button-class');

                $(this).click(function () {
                    swal({
                            title: sa_title,
                            text: sa_message,
                            type: sa_type,
                            allowOutsideClick: sa_allowOutsideClick,
                            showConfirmButton: sa_showConfirmButton,
                            showCancelButton: sa_showCancelButton,
                            confirmButtonClass: sa_confirmButtonClass,
                            cancelButtonClass: sa_cancelButtonClass,
                            closeOnConfirm: sa_closeOnConfirm,
                            closeOnCancel: sa_closeOnCancel,
                            confirmButtonText: sa_confirmButtonText,
                            cancelButtonText: sa_cancelButtonText,
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                var orderproductIds = $("input[name='orderproductsCheckbox[]']:checked").map(function () {
                                    return $(this).val();
                                }).get();
                                if (detachOrderproductAjax) {
                                    detachOrderproductAjax.abort();
                                }
                                toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "positionClass": "toast-top-center",
                                    "onclick": null,
                                    "showDuration": "1000",
                                    "hideDuration": "1000",
                                    "timeOut": "5000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                };
                                detachOrderproductAjax = $.ajax({
                                    type: "POST",
                                    url: actionUrl_detachOrderproduct,
                                    data: {orderproducts: orderproductIds, order: order_id },
                                    statusCode: {
                                        200: function (response) {
                                            location.reload();
                                        },
                                        401: function (ressponse) {
                                            location.reload();
                                        },
                                        403: function (response) {
                                            window.location.replace("/403");
                                        },
                                        404: function (response) {
                                            window.location.replace("/404");
                                        },
                                        503: function (response) {
                                            toastr["error"]($.parseJSON(response.responseText).message, "پیام سیستم");
                                        }
                                    }
                                });
                                // swal(sa_popupTitleSuccess, sa_popupMessageSuccess, "success");
                            } else {
                                // swal(sa_popupTitleCancel, sa_popupMessageCancel, "error");
                            }
                        });
                });
            });

        }
    }

}();

function obtainDebt() {
    var debt = 0;
    $('.orderproductExchangeNewCost').each(function (i, obj) {
        var orderproduct = $(this).data("role");
        var originalCost = $("#orderproductExchangeOriginalCost_" + orderproduct).text();
        var newCost = $(this).val();
        if (newCost.length > 0)
            debt = debt + (parseInt(originalCost) - parseInt(newCost));
    });
    $('.orderproductExchangeNewDiscountAmount').each(function (i, obj) {
        var newDiscountAmount = $(this).val();
        if (newDiscountAmount.length > 0)
            debt = parseInt(debt) + parseInt(newDiscountAmount);
    });
    $('.neworderproductCost').each(function (i, obj) {
        var newCost = $(this).val();
        if (newCost.length > 0)
            debt = debt - newCost;
    });

    var transactionCost = $("#orderproductExchangeTransactionCost").val();
    if (transactionCost.length > 0) debt = debt - parseInt(transactionCost);
    if (debt < 0) $("#orderproductExchangeDebt").css("color", "red");
    else $("#orderproductExchangeDebt").css("color", "black");
    return debt;
}

$(document).on("click", "#orderproductExchangeButton", function () {
    var orderproductIds = $("input[name='orderproductsCheckbox[]']:checked").map(function () {
        return $(this).val();
    }).get();

    $(".orderproductDiv").hide();
    $(".orderproductDiv :input").attr("disabled", true);

    $.each(orderproductIds, function (index, value) {
        $("#orderproductDiv_" + value).show();
        $("#orderproductDiv_" + value + " :input").attr("disabled", false);
    });

});


$(document).on("change", ".orderproductExchangeNewProductSelect", function () {
    var orderproduct = $(this).data("role");
    if ($(this).find(':selected').val() != 0) {
        var cost = $(this).find(':selected').data('content');
        $("#orderproductExchangeNewCost_" + orderproduct).val(cost);
    } else {
        $("#orderproductExchangeNewCost_" + orderproduct).val(null);
    }

    var debt = obtainDebt();
    if (debt < 0)
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
    else
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
});

$('.orderproductExchangeNewCost').on('input', function (e) {
    var debt = obtainDebt();
    if (debt < 0)
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
    else
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
});

$('.orderproductExchangeNewDiscountAmount').on('input', function (e) {
    var debt = obtainDebt();
    if (debt < 0)
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
    else
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
});

$(document).on("change", ".orderproductExchange-newOrderproductProduct", function () {
    var orderproduct = $(this).data("role");
    if ($(this).find(':selected').val() != 0) {
        var cost = $(this).find(':selected').data('content');
        $("#neworderproductCost_" + orderproduct).val(cost);
    } else {
        $("#neworderproductCost_" + orderproduct).val(null);
    }
    var debt = obtainDebt();
    if (debt < 0)
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
    else
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
});

$('.neworderproductCost').on('input', function (e) {
    var debt = obtainDebt();
    if (debt < 0)
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
    else
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
});

$("#orderproductExchangeTransactionCost").on('input', function (e) {
    var debt = obtainDebt();
    if (debt < 0)
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true).append("-");
    else
        $("#orderproductExchangeDebt").text(obtainDebt()).number(true);
});

$("#orderproductExchangeTransacctionCheckbox").on('change', function (e) {
    if ($(this).is(':checked')) {
        $("#orderproductExchangeTransacction").prop("disabled", false);
    } else {
        $("#orderproductExchangeTransacction").prop("disabled", true);
    }
});
