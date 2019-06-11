@extends('app',['pageName'=>$pageName])

@section('page-css')
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
{{--                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>--}}
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پنل مدیریت بلاک ها</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <!-- BEGIN BLOCK TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="block-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت بلاک ها
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="block-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="la la-refresh"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="block-expand">
                                    <i class="la la-expand"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-close"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a id="sample_editable_4_new" class="btn btn-info m-btn m-btn--icon m-btn--wide" data-toggle="modal" href="#responsive-block" data-target="#responsive-block">
                                        <i class="fa fa-plus"></i>
                                        افزودن بلاک
                                    </a>
                                    <!--begin::Modal-->
                                    <div class="modal fade" id="responsive-block" tabindex="-1" role="dialog" aria-labelledby="responsive-blockModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="responsive-blockModalLabel">افزودن بلاک جدید</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!! Form::open(['files'=>true,'method' => 'POST','action' => ['Web\BlockController@store'], 'class'=>'nobottommargin' , 'id'=>'blockForm']) !!}
                                                <div class="modal-body">
                                                    <div class="row">
{{--                                                        @include('block.form')--}}
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                                    <button type="button" class="btn btn-primary" id="blockForm-submit">ذخیره</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--begin::Modal-->
                    <div class="modal fade" id="copyBlockModal" tabindex="-1" role="dialog" aria-labelledby="copyBlockModalModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="copyBlockModalModalLabel"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h4 class="modal-title">آیا برای کپی مطمئن هستید؟</h4>
                                    <input type="hidden" id="blockIdForCopy" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                    <button type="button" class="btn btn-primary" onclick="copyBlockInModal()">بله</button>
                                    <img class="d-none" id="copy-block-loading-image" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
    
                    <!--begin::Modal-->
                    <div class="modal fade" id="removeBlockModal" tabindex="-1" role="dialog" aria-labelledby="removeBlockModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="removeBlockModalLabel"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h4 class="modal-title">آیا مطمئن هستید؟</h4>
                                    <input type="hidden" id="block-removeLink" value="removeLink">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                    <button type="submit" class="btn btn-primary btnRemoveBlockInModal" onclick="removeBlock()">بله</button>
                                    <img class="d-none" id="remove-block-loading-image" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
                    
                    <!--begin::Modal-->
                    <div class="modal fade" id="showBlockPhotoInModal" tabindex="-1" role="dialog" aria-labelledby="showBlockPhotoInModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showBlockPhotoInModalLabel"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="" alt="" class="a--full-width">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
    
    
                    <!--begin::Modal-->
                    <div class="modal fade" id="static-longDescription" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
            
                    <table class="table table-striped table-bordered table-hover" width="100%" id="block_table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>عنوان</th>
                                <th>ترتیب</th>
                                <th>تعداد پیشنهادها</th>
                                <th>تعداد محتوا</th>
                                <th>تعداد دسته ها</th>
                                <th>تعداد محصولات</th>
                                <th>تعداد بنرها</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section('page-js')
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/datatable.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-extended-modals.min.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-editors.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        function generateRemoveBlockLink(blockId) {
            return '{{ asset('/') }}/blockRemove/'+blockId;
        }
        function generateEditBlockLink(blockId) {
            return '{{ asset('/') }}/blockEdit/'+blockId;
        }
        
        function makeDataTable_loadWithAjax_blocks(dontLoadAjax) {

            var newDataTable =$("#block_table").DataTable();
            newDataTable.destroy();
            
            $('#block_table > tbody').html("");
            let defaultContent = "<span class=\"m-badge m-badge--wide label-sm m-badge--danger\"> درج نشده </span>";
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
                        var contents = row.contents;
                        if (typeof contents !== 'undefined' && contents !== null && contents !== false) {
                            return contents.length;
                        }
                    },
                },
                {
                    "data": null,
                    "name": "sets.count",
                    "title": "تعداد دسته ها",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        var sets = row.sets;
                        if (typeof sets !== 'undefined' && sets !== null && sets !== false) {
                            return sets.length;
                        }
                    },
                },
                {
                    "data": null,
                    "name": "products.count",
                    "title": "تعداد محصولات",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        var products = row.products;
                        if (typeof products !== 'undefined' && products !== null && products !== false) {
                            return products.length;
                        }
                    },
                },
                {
                    "data": null,
                    "name": "banners.count",
                    "title": "تعداد بنرها",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        var banners = row.banners;
                        if (typeof banners !== 'undefined' && banners !== null && banners !== false) {
                            return banners.length;
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
                            '    <a class="btn btn-danger btnDeleteOrder" remove-link="' + row.removeLink + '" data-block-name="' + row.title + '">\n' +
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
                data.blockPage = getNextPageParam(data.start, data.length);
                delete data.columns;
                return data;
            };
            let dataSrc = function (json) {
                console.log('json.data: ', json.data);
                $("#block-portlet-loading").addClass("d-none");
                mApp.unblock('#block_table_wrapper');
                return json.data;
            };
            let url = '/blockAdmin/list';
            if (dontLoadAjax) {
                url = null;
            } else {
                $("#block-portlet-loading").removeClass("d-none");
            }
            let dataTable = makeDataTable_loadWithAjax("block_table", url, columns, dataFilter, ajaxData, dataSrc);
            return dataTable;
        }
    </script>
    <script src="/acm/AlaatvCustomFiles/js/admin-indexBlock.js" type="text/javascript"></script>
    
    <script src="/acm/AlaatvCustomFiles/js/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-coupon.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-block.js" type="text/javascript"></script>
    <script type="text/javascript">
        /**
         * Start up jquery
         */
        function showLongDescription(LongDescriptionId) {
            let txtLongDescription = $('#txtLongDescription-'+LongDescriptionId).html();
            $('#static-longDescription .modal-body').html(txtLongDescription);
            $('#static-longDescription').modal('show');
        }
        function showCopyBlockModal(blockId, blockName) {
            $('#blockIdForCopy').val(blockId);
            $('#copyBlockModalModalLabel').html(blockName);
            $('#copyBlockModal').modal('show');
        }
        
        jQuery(document).ready(function () {

            $(document).on('click', '.imgShowBlockPhoto', function () {
               let src = $(this).attr('src');
               let alt = $(this).attr('src');
               let name = $(this).data('block-name');
               $('#showBlockPhotoInModalLabel').html(name);
               $('#showBlockPhotoInModal .modal-body img').attr('src', src);
               $('#showBlockPhotoInModal .modal-body img').attr('alt', alt);
               $('#showBlockPhotoInModal').modal('show');
            });

            $(document).on('click', '.btnDeleteOrder', function (e) {
                e.preventDefault();
                let removeLink = $(this).attr('remove-link');
                let name = $(this).data('block-name');

               $('#removeBlockModalLabel').html(name);
               $('#block-removeLink').val(removeLink);
               $('#removeBlockModal').modal('show');
            });
            /*
             validdSince
             */
            $("#couponValidSince").persianDatepicker({
                altField: '#couponValidSinceAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });

            /*
             validUntil
             */
            $("#couponValidUntil").persianDatepicker({
                altField: '#couponValidUntilAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });


            $(document).on("click", "#block-portlet .reload", function (){
                $("#block-portlet-loading").removeClass("d-none");
                $('#block_table > tbody').html("");
                makeDataTable_loadWithAjax_blocks();
                return false;
            });
            
            $("#block-portlet .reload").trigger("click");
            $("#block-expand").trigger("click");
            $('#blockShortDescriptionSummerNote').summernote({height: 200});
            $('#blockLongDescriptionSummerNote').summernote({height: 200});

        });

    </script>
@endsection