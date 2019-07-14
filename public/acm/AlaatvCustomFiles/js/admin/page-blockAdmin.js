
function makeDataTable_loadWithAjax_blocks(dontLoadAjax) {

    var newDataTable =$("#block_table").DataTable();
    newDataTable.destroy();

    $('#block_table > tbody').html("");
    let defaultContent = "<span class=\"m-badge m-badge--wide label-sm m-badge--danger\"> درج نشده </span>";
    let zeroContent = "<span class=\"m-badge m-badge--wide label-sm m-badge--warning\"> خالی </span>";
    let columns = [
        {data: "res", title: "", defaultContent: ' '},
        {data: "id", title: "#", defaultContent: defaultContent},
        {data: "title", title: "عنوان", defaultContent: defaultContent},
        {data: "order", title: "ترتیب", defaultContent: defaultContent},
        {
            "data": null,
            "name": "offer.count",
            "title": "تعداد پیشنهادها",
            defaultContent: defaultContent,
            "render": function ( data, type, row ) {
                var offer = row.offer;
                if (typeof offer !== 'undefined' && offer !== null && offer !== false) {
                    return offer.length;
                }
            },
        },
        {
            "data": null,
            "name": "contents.count",
            "title": "تعداد محتوا",
            defaultContent: defaultContent,
            "render": function ( data, type, row ) {
                if (row.contents_count > 0) {
                    return row.contents_count;
                } else {
                    return zeroContent;
                }
            },
        },
        {
            "data": null,
            "name": "sets.count",
            "title": "تعداد دسته ها",
            defaultContent: defaultContent,
            "render": function ( data, type, row ) {
                if (row.sets_count > 0) {
                    return row.sets_count;
                } else {
                    return zeroContent;
                }
            },
        },
        {
            "data": null,
            "name": "products.count",
            "title": "تعداد محصولات",
            defaultContent: defaultContent,
            "render": function ( data, type, row ) {
                if (row.products_count > 0) {
                    return row.products_count;
                } else {
                    return zeroContent;
                }
            },
        },
        {
            "data": null,
            "name": "banners.count",
            "title": "تعداد بنرها",
            defaultContent: defaultContent,
            "render": function ( data, type, row ) {
                if (row.banners_count > 0) {
                    return row.banners_count;
                } else {
                    return zeroContent;
                }
            },
        },
        {
            "data": null,
            "name": "functions",
            "title": "عملیات",
            defaultContent: '',
            "render": function ( data, type, row ) {
                let html = '<div class="btn-group">\n';
                html +=
                    '    <a target="_blank" class="btn btn-success" href="' + row.editLink + '">\n' +
                    '        <i class="fa fa-pencil"></i> اصلاح \n' +
                    '    </a>\n';
                html +=
                    '    <a class="btn btn-danger btnDeleteBlock" remove-link="' + row.removeLink + '" data-block-name="' + row.title + '">\n' +
                    '        <i class="fa fa-remove" aria-hidden="true"></i> حذف \n' +
                    '    </a>\n';
                html += '</div>';

                return html;
            },
        },
    ];

    let dataFilter = function(data){
        let json = jQuery.parseJSON( data );
        json.recordsTotal = json.total;
        json.recordsFiltered = json.total;
        // for (let index in json.data) {
        //     if(!isNaN(index)) {
        //         json.data[index]['full_name'] =
        //     }
        // }
        //
        return JSON.stringify( json ); // return JSON string
    };
    let ajaxData = function (data) {
        mApp.block('#block_table_wrapper', {
            type: "loader",
            state: "info",
        });
        data.page = getNextPageParam(data.start, data.length);
        delete data.columns;
        return data;
    };
    let dataSrc = function (json) {
        $("#block-portlet-loading").addClass("d-none");
        mApp.unblock('#block_table_wrapper');
        return json.data;
    };
    let url = '/block';
    if (dontLoadAjax) {
        url = null;
    } else {
        $("#block-portlet-loading").removeClass("d-none");
    }
    let dataTable = makeDataTable_loadWithAjax("block_table", url, columns, dataFilter, ajaxData, dataSrc);
    return dataTable;
}
function removeBlock(){
    mApp.block('#removeBlockModal', {
        type: "loader",
        state: "success",
    });
    var remove_link = $('#block-removeLink').val();
    $.ajax({
        type: 'DELETE',
        url: remove_link,
        data:{_method: 'delete'},
        success: function (result) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-bottom-center",
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
            toastr["success"]("بلاک با موفقیت حذف شد!", "پیام سیستم");
            $('#removeBlockModal').modal('hide');
            mApp.unblock('#removeBlockModal');

            makeDataTable_loadWithAjax_blocks();
        },
        error: function (result) {
            mApp.unblock('#removeBlockModal');
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-bottom-center",
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
            toastr["warning"]("مشکلی در حذف بلاک رخ داده است.", "پیام سیستم");
            $('#removeBlockModal').modal('hide');
            makeDataTable_loadWithAjax_blocks();
        }
    });
}

jQuery(document).ready(function () {

    $("input.blockTags").tagsinput({
        tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
    });

    $(document).on('click', '.imgShowBlockPhoto', function () {
        let src = $(this).attr('src');
        let alt = $(this).attr('src');
        let name = $(this).data('block-name');
        $('#showBlockPhotoInModalLabel').html(name);
        $('#showBlockPhotoInModal .modal-body img').attr('src', src);
        $('#showBlockPhotoInModal .modal-body img').attr('alt', alt);
        $('#showBlockPhotoInModal').modal('show');
    });

    $(document).on('click', '.btnDeleteBlock', function (e) {
        e.preventDefault();
        let removeLink = $(this).attr('remove-link');
        let name = $(this).data('block-name');

        $('#removeBlockModalLabel').html(name);
        $('#block-removeLink').val(removeLink);
        $('#removeBlockModal').modal('show');
    });

    $(document).on("click", "#block-portlet .reload", function (){
        $("#block-portlet-loading").removeClass("d-none");
        $('#block_table > tbody').html("");
        makeDataTable_loadWithAjax_blocks();
        return false;
    });

    $("#block-portlet .reload").trigger("click");

});
