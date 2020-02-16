@extends('partials.templatePage')

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پنل مدیریت لیست</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            @permission((config('constants.LIST_EVENTRESULT_ACCESS')))
            <!-- BEGIN Kunkur 96 TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--danger m-portlet--collapsed m-portlet--head-sm eventResult-portlet" m-portlet="true" id="konkur96-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                لیست نتایج کنکور 96
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="konkurResult96-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            @permission((config('constants.LIST_EVENTRESULT_ACCESS')))
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload" data-role="konkurResult96">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            @endpermission
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="konkurResult96-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="portlet box blue d-none">
                        <style>
                            .form .form-row-seperated .form-group {
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class="portlet-body form" style="border-top: #3598dc solid 1px">
                            {!! Form::open(['class'=>'form-horizontal form-row-seperated' , 'id' => 'filterkonkurResult96Form']) !!}
                            <input type="hidden" name="event_id[]" value="1">
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group"></div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                           id="konkurResult96_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> دانش آموز</th>
                            <th class="min-tablet">رشته</th>
                            @permission((config('constants.SHOW_USER_MOBILE')))
                            <th class="min-tablet"> شماره تماس</th>
                            @endpermission
                            @permission((config('constants.SHOW_USER_CITY')))
                            <th class="min-tablet"> شهر</th>
                            @endpermission
                            @permission((config('constants.SHOW_KONKOOT_RESULT_INFO')))
                            <th class="min-tablet"> فایل کارنامه</th>
                            @endpermission
                            <th class="all"> رتبه</th>
                            @permission((config('constants.SHOW_KONKOOT_RESULT_INFO')))
                            <th class="all">اجازه انتشار</th>
                            <th class="min-tablet"> وضعیت</th>
                            @endpermission
                            <th class="min-tablet"> نظر</th>
                            @permission((config('constants.SHOW_KONKOOT_RESULT_INFO')))
                            <th class="min-tablet"> تاریخ درج</th>
                            @endpermission
                        </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->

            <!-- BEGIN Konkur 97 TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--brand m-portlet--collapsed m-portlet--head-sm eventResult-portlet" m-portlet="true" id="konkur97-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                لیست نتایج کنکور 97
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="konkurResult97-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            @permission((config('constants.LIST_EVENTRESULT_ACCESS')))
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload" data-role="konkurResult97">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            @endpermission
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="konkurResult97-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="portlet box blue d-none">
                        <style>
                            .form .form-row-seperated .form-group {
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class="portlet-body form" style="border-top: #3598dc solid 1px">
                            {!! Form::open(['class'=>'form-horizontal form-row-seperated' , 'id' => 'filterkonkurResult97Form']) !!}
                            <input type="hidden" name="event_id[]" value="3">
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group"></div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                           id="konkurResult97_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> دانش آموز</th>
                            <th class="min-tablet">رشته</th>
                            @permission((config('constants.SHOW_USER_MOBILE')))
                            <th class="min-tablet"> شماره تماس</th>
                            @endpermission
                            @permission((config('constants.SHOW_USER_CITY')))
                            <th class="min-tablet"> شهر</th>
                            @endpermission
                            @permission((config('constants.SHOW_KONKOOT_RESULT_INFO')))
                            <th class="min-tablet"> فایل کارنامه</th>
                            @endpermission
                            <th class="all"> رتبه</th>
                            @permission((config('constants.SHOW_KONKOOT_RESULT_INFO')))
                            <th class="all">اجازه انتشار</th>
                            <th class="min-tablet"> وضعیت</th>
                            @endpermission
                            <th class="min-tablet"> نظر</th>
                            @permission((config('constants.SHOW_KONKOOT_RESULT_INFO')))
                            <th class="min-tablet"> تاریخ درج</th>
                            @endpermission
                        </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->

            <!-- BEGIN Konkun98 TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--brand m-portlet--collapsed m-portlet--head-sm eventResult-portlet" m-portlet="true" id="konkur98-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                لیست نتایج کنکور 98
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="konkurResult98-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            @permission((config('constants.LIST_EVENTRESULT_ACCESS')))
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload" data-role="konkurResult98">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            @endpermission
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="konkurResult98-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="portlet box blue d-none">
                        <style>
                            .form .form-row-seperated .form-group {
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class="portlet-body form" style="border-top: #3598dc solid 1px">
                            {!! Form::open(['class'=>'form-horizontal form-row-seperated' , 'id' => 'filterkonkurResult98Form']) !!}
                            <input type="hidden" name="event_id[]" value="4">
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group"></div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                           id="konkurResult98_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> دانش آموز</th>
                            <th class="min-tablet">رشته</th>
                            @permission((config('constants.SHOW_USER_MOBILE')))
                            <th class="min-tablet"> شماره تماس</th>
                            @endpermission
                            @permission((config('constants.SHOW_USER_CITY')))
                            <th class="min-tablet"> شهر</th>
                            @endpermission
                            @permission((config('constants.SHOW_KONKOOT_RESULT_INFO')))
                            <th class="min-tablet"> فایل کارنامه</th>
                            @endpermission
                            <th class="all"> رتبه</th>
                            @permission((config('constants.SHOW_KONKOOT_RESULT_INFO')))
                            <th class="all">اجازه انتشار</th>
                            <th class="min-tablet"> وضعیت</th>
                            @endpermission
                            <th class="min-tablet"> نظر</th>
                            @permission((config('constants.SHOW_KONKOOT_RESULT_INFO')))
                            <th class="min-tablet"> تاریخ درج</th>
                            @endpermission
                        </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
            @endpermission

            @if(false)
            @permission((config('constants.LIST_SHARIF_REGISTER_ACCESS')))
            <!-- BEGIN QUESTION TABLE PORTLET-->
            <div class="m-portlet m-portlet--collapsed m-portlet--head-sm eventResult-portlet" m-portlet="true" id="schoolRegister-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                لیست پیش ثبت نام شریف
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="sharifRegisterResult-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            @permission((config('constants.LIST_SHARIF_REGISTER_ACCESS')))
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload" data-role="sharifRegisterResult">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            @endpermission
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="sharifRegisterResult-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="portlet box blue d-none">
                        <style>
                            .form .form-row-seperated .form-group {
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class="portlet-body form" style="border-top: #3598dc solid 1px">
                            {!! Form::open(['class'=>'form-horizontal form-row-seperated' , 'id' => 'filtersharifRegisterResultForm']) !!}
                            <input type="hidden" name="event_id[]" value="2">
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group"></div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sharifRegisterResult_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام خانوادگی</th>
                            <th class="all"> نام</th>
                            <th class="all"> استان</th>
                            <th class="all"> شهر</th>
                            <th class="min-tablet"> شماره تماس</th>
                            <th class="min-tablet">رشته</th>
                            <th class="all"> پایه</th>
                            <th class="all"> معدل</th>
                            <th class="min-tablet"> تاریخ ثبت نام</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
            @endpermission
            @endif
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        /**
         * Event Result Admin Ajax
         */
        $(document).on("click", ".eventResult-portlet .reload", function () {
            var identifier = $(this).data("role");
            var formData = $("#filter" + identifier + "Form").serialize();
            $("#" + identifier + "-portlet-loading").removeClass("d-none");
            $('#' + identifier + '_table > tbody').html("");
            $.ajax({
                type: "GET",
                url: "/eventresult",
                data: formData,
                success: function (result) {
                    var newDataTable = $("#" + identifier + "_table").DataTable();
                    newDataTable.destroy();
                    $('#' + identifier + '_table > tbody').html(result);
                    makeDataTable(identifier + "_table");
                    $("#" + identifier + "-portlet-loading").addClass("d-none");
                },
                error: function (result) {
                }
            });

            return false;
        });
        $(document).on("click", ".eventResultUpdate", function (e) {
            e.preventDefault();
            var eventresult_id = $(this).data('role');
            var form = $("#eventResultForm_" + eventresult_id);
            formData = form.serialize();
            url = form.attr("action");
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
            $.ajax({
                type: 'PUT',
                url: url,
                data: formData,
                statusCode: {
                    200: function (response) {
                        $("#eventresult_id .reload").trigger("click");
                        toastr["success"]("اصلاح وضعیت با موفقیت انجام شد!", "پیام سیستم");

                    },
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    422: function (response) {
                        var errors = $.parseJSON(response.responseText);
                        $.each(errors, function (index, value) {
                            switch (index) {
                            }
                        });
                    },
                    500: function (response) {
                        toastr["error"]("خطای برنامه!", "پیام سیستم");
                    },
                    503: function (response) {
                        toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                    }
                },
                cache: false,
                processData: false
            });
        });


        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
        @permission((config('constants.LIST_EVENTRESULT_ACCESS')));
            $("#konkur96-portlet .reload").trigger("click");
            $("#konkurResult96-expand").trigger("click");
            $("#konkur97-portlet .reload").trigger("click");
            $("#konkurResult97-expand").trigger("click");
            $("#konkur98-portlet .reload").trigger("click");
            $("#konkurResult98-expand").trigger("click");
        @endpermission;

        @permission((config('constants.LIST_SHARIF_REGISTER_ACCESS')));
            $("#schoolRegister-portlet .reload").trigger("click");
            $("#sharifRegisterResult-expand").trigger("click");
        @endpermission;
        });
    </script>
@endsection
