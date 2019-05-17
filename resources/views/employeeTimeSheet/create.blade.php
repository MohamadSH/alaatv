@extends('app')

@section('page-css')
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css"/>
{{--    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>--}}
{{--    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css" rel="stylesheet" type="text/css"/>
    <style>
        .datepicker-header {
            direction: ltr;
        }
    </style>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پنل ثبت ساعت کاری</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    @include("systemMessage.flash")
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__body">

                    <div class="row">
                        @if(Auth::user()->can(config('constants.INSERT_EMPLOPYEE_WORK_SHEET')))
                            {!! Form::open( ['method' => 'POST','action' => ['Web\EmployeetimesheetController@store'] , 'class'=>'form-horizontal col' ,'accept-charset'=>'UTF-8' , 'enctype'=>'multipart/form-data']) !!}
                            <div class="col">
                                @include('employeeTimeSheet.form')
                            </div>
                            {!! Form::close() !!}
                        @else
                            @if(isset($employeetimesheet))
                                @if($employeetimesheet->getOriginal("timeSheetLock"))
                                    <h4 class="m--font-danger text-center bold col">ساعت کاری امروز شما قفل شده است</h4>
                                @else
                                    {!! Form::model( $employeetimesheet,['method' => 'POST','action' => ['Web\UserController@submitWorkTime'] , 'class'=>'form-horizontal col' ,'accept-charset'=>'UTF-8' , 'enctype'=>'multipart/form-data']) !!}
                                    @include('employeeTimeSheet.form')
                                    {!! Form::close() !!}
                                @endif
                            @elseif(isset($formVisible) && $formVisible)
                                {!! Form::open( ['method' => 'POST','action' => ['Web\UserController@submitWorkTime'] , 'class'=>'form-horizontal col' ,'accept-charset'=>'UTF-8' , 'enctype'=>'multipart/form-data']) !!}
                                @include('employeeTimeSheet.form')
                                {!! Form::close() !!}
                            @endif
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__body">
                    <div class="portlet box blue">
                        <style>
                            .form .form-row-seperated .form-group {
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class="portlet-body form " style="border-top: #3598dc solid 1px">
                            {!! Form::open(['action' => 'Web\EmployeetimesheetController@index' ,'class'=>'form-horizontal form-row-seperated' , 'id' => 'filterEmployeeTimeSheetForm']) !!}
                            <div class="form-body m--padding-10" style="background: #e7ecf1">
                                <div class="form-group">
                                    <div class="row">
                                        @if(Auth::user()->can(config('constants.LIST_EMPLOPYEE_WORK_SHEET')))
                                            <div class="col-lg-3 col-md-3 col-sd-3">
                                                @include("admin.filters.selectUserFilter" , ["caption" => "انتخاب کارمند" , "users"=>$employees])
                                            </div>
                                        @else
                                            {!! Form::hidden('users[]', Auth::user()->id) !!}
                                        @endif
                                        <div class="col-lg-3 col-md-3 col-sd-3">
                                            {!! Form::select('workdayTypes[]', $workdayTypes, null, ['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default',
                                                         "id"=>"workdayTypesFilter" ,"data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" ,
                                                        "data-height" => "200" , "title" => "نوع روز کاری" ]) !!}
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sd-3">
                                            {!! Form::select('isPaid',[0=>"تسویه نشده"  , 1=>"تسویه شده"],null,['class' => 'form-control' , 'placeholder'=>'تسویه شده و نشده']) !!}
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-3 col-xs-12">
                                                    {{--<label class="col-md-2 bold control-label">تاریخ</label>--}}
                                                    <label class="control-label" style="float: right;">
                                                        <label class="mt-checkbox mt-checkbox-outline">
                                                            <input type="checkbox" id="dateEnable" value="1" name="dateEnable" checked>
                                                            <span class="bg-grey-cararra"></span>
                                                        </label>
                                                    </label>
                                                    <label class="control-label" style=" float: right;">از تاریخ</label>
                                                    <div>
                                                        <input id="sinceDate" type="text" class="form-control">
                                                        <input name="sinceDate" id="sinceDateAlt" type="text" class="form-control d-none">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-xs-12">
                                                    <label class="control-label" style="float: right;">تا تاریخ</label>
                                                    <div>
                                                        <input id="tillDate" type="text" class="form-control">
                                                        <input name="tillDate" id="tillDateAlt" type="text" class="form-control d-none">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sd-12">
                                            <a href="javascript:" class="btn btn-lg bg-font-dark reload" id="filterButton" style="background: #489fff">فیلتر</a>
                                            <img class="d-none" id="employeeTimeSheet-portlet-loading" src="{{config("constants.FILTER_LOADING_GIF")}}" alt="loading" width="5%">

                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sd-12">
                                            <h5 class="bold">جمع کل اضافه کاری در بازه انتخاب شده:
                                                <span class="m--font-info" dir="ltr" id="sumWorkSheet"></span>
                                            </h5>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sd-12">
                                            <h5 class="bold">جمع کل ساعت کاری در بازه انتخاب شده:
                                                <span class="m--font-info" dir="ltr" id="sumRealWorkTime"></span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    {{--delete user confirmation modal--}}


                    <!--begin::Modal-->
                    <div class="modal fade" id="deleteEmployeetimesheetConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteEmployeetimesheetConfirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteEmployeetimesheetConfirmationModalLabel">
                                        حذف ساعت کاری
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p> آیا مطمئن هستید؟</p>
                                    {!! Form::hidden('employeetimesheet_id', null) !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="removeEmployeetimesheet()">بله</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
                    
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="employeeTimeSheet_table">
                        <thead>
                        <tr>
                            <th></th>
                            @permission((config('constants.LIST_EMPLOPYEE_WORK_SHEET')))
                            <th class="all"> نام</th>
                            @endpermission
                            <th class="all"> تاریخ</th>
                            <th class="desktop"> روز</th>
                            @permission((config('constants.LIST_EMPLOPYEE_WORK_SHEET')))
                            <th class="none"> عملیات</th>
                            @endpermission
                            <th class="none"> مدت شیفت کاری</th>
                            <th class="desktop"> کل ساعت کار</th>
                            <th class="none"> زمان ناهار</th>
                            <th class="desktop"> زمان استراحت اضافه</th>
                            <th class="desktop"> اضافه یا کم کاری</th>
                            <th class="none"> شروع شیفت</th>
                            <th class="none"> پایان شیفت</th>
                            <th class="desktop"> ورود</th>
                            <th class="desktop"> خروج ناهار</th>
                            <th class="desktop"> ورود بعد ناهار</th>
                            <th class="desktop"> خروج نهایی</th>
                            <th class="none"> استراحت(کسری)</th>
                            <th class="none"> قفل شده</th>
                            @permission((config('constants.LIST_EMPLOPYEE_WORK_SHEET')))
                            <th class="none"> تسویه شده</th>
                            @endpermission
                            <th class="none"> نوع ساعت کاری</th>
                            <th class="none"> توضیحات کامند</th>
                            <th class="none"> توضیحات مدیر</th>
                            @permission((config('constants.LIST_EMPLOPYEE_WORK_SHEET')))
                            <th class="none"> زمان اصلاح</th>
                            <th class="none"> نام اصلاح کننده</th>
                            <th class="none"> زمان درج</th>
                            @endpermission
                        </tr>
                        </thead>
                        <tbody align="center">
                        {{--Loading by Ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/datatable.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/icheck/icheck.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>--}}
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-editors.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/app.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/form-input-mask.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/form-icheck.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-extended-modals.min.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/js/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-makeMultiSelect.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            /**
             * Set token for ajax request
             */
            $(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken,
                    }
                });
            });

// Ajax of Modal forms
            var $modal = $('#ajax-modal');

            $('#employeeCommentSummerNote').summernote({height: 200, placeholder: "توضیحات کارمند"});
            $('#managerCommentSummerNote').summernote({height: 200, placeholder: "توضیحات مدیر"});

            $("#date").persianDatepicker({
                altField: '#dateAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });

            $("#sinceDate").persianDatepicker({
                altField: '#sinceDateAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });

            $("#tillDate").persianDatepicker({
                altField: '#tillDateAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });

            $('#dateEnable').click(function () {
                if ($('#dateEnable').prop('checked') == true) {
                    $('#sinceDate').attr('disabled', false);
                    $('#tillDate').attr('disabled', false);
                } else {
                    $('#sinceDate').attr('disabled', true);
                    $('#tillDate').attr('disabled', true);
                }
            });

            $("#clockIn").inputmask("hh:mm", {
                placeholder: "",
                clearMaskOnLostFocus: true
            });
            $("#beginLunchBreak").inputmask("hh:mm", {
                placeholder: "",
                clearMaskOnLostFocus: true
            });
            $("#finishLunchBreak").inputmask("hh:mm", {
                placeholder: "",
                clearMaskOnLostFocus: true
            });
            $("#clockOut").inputmask("hh:mm", {
                placeholder: "",
                clearMaskOnLostFocus: true
            });
            $("#breakDurationInSeconds").inputmask("hh:mm", {
                placeholder: "",
                clearMaskOnLostFocus: true
            });
            $("#userBeginTime").inputmask("hh:mm", {
                placeholder: "",
                clearMaskOnLostFocus: true
            });
            $("#userFinishTime").inputmask("hh:mm", {
                placeholder: "",
                clearMaskOnLostFocus: true
            });
            $("#allowedLunchBreakInSec").inputmask("hh:mm", {
                placeholder: "",
                clearMaskOnLostFocus: true
            });

        @ability(Config::get("constants.EMPLOYEE_ROLE"), Config::get("constants.LIST_EMPLOPYEE_WORK_SHEET"));
            $("#filterButton").trigger("click");
        @endability
        });

        @ability(Config::get("constants.EMPLOYEE_ROLE"), Config::get("constants.LIST_EMPLOPYEE_WORK_SHEET"));
        var userAjax;
        $(document).on("click", "#filterButton", function () {
            $("#employeeTimeSheet-portlet-loading").removeClass("d-none");
            $('#employeeTimeSheet_table > tbody').html("");

            var formData = $("#filterEmployeeTimeSheetForm").serialize();

//            if($("#employeeTimeSheetTableColumnFilter").val() !== null) {
//                var columns = $("#employeeTimeSheetTableColumnFilter").val();
//                $("#employeeTimeSheet_table thead tr th").each(function() {
//                    if(columns.includes($(this).text().trim())){
//                        $(this).removeClass().addClass("all");
//                    }
//                    else if($(this).text() !== "") {
//                        $(this).removeClass().addClass("none");
//                    }
//                });
//            }
//            else {
//                $("#employeeTimeSheet_table thead tr th").each(function() {
//                    $(this).removeClass().addClass("none");
//                });
//            }
            if (userAjax) {
                userAjax.abort();
            }
            userAjax = $.ajax({
                type: "GET",
                url: $("#filterEmployeeTimeSheetForm").attr("action"),
                data: formData,
                contentType: "application/json",
                dataType: "json",
                statusCode: {
                    200: function (response) {
//                        var responseJson = response;
                        var newDataTable = $("#employeeTimeSheet_table").DataTable();
                        newDataTable.destroy();
                        $('#employeeTimeSheet_table > tbody').html(response.index);
                        $("#sumWorkSheet").html(response.employeeWorkSheetSum);
                        $("#sumRealWorkTime").html(response.employeeRealWorkTime);
//                        if(response === null || response === "" ) {
//                            $('#employeeTimeSheet_table > thead > tr').children('th:first').removeClass().addClass("none");
//                        }
//                        else{
//                            $('#employeeTimeSheet_table > thead > tr').children('th:first').removeClass("none");
//                        }
                        makeDataTable("employeeTimeSheet_table");
                        $("#employeeTimeSheet-portlet-loading").addClass("d-none");
//                        $(".filter").each(function () {
//                            if($(this).val() !== "" && $(this).val() !== null) {
//                                $(this).addClass("m--font-danger");
//                            }
//                        });
                    },
                    //The status for when the user is not authorized for making the request
                    401: function (ressponse) {
                        location.reload();
                    },
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        //
                    },
                    //The status for when there is error php code
                    500: function (response) {
                        console.log(response.responseText);
                        toastr["error"]("خطای برنامه!", "پیام سیستم");
                    },
                    //The status for when there is error php code
                    503: function (response) {
                        toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                    }
                }
            });

            return false;
        });
        @endability;

        @permission((Config::get('constants.REMOVE_EMPLOPYEE_WORK_SHEET')));
        $(document).on("click", ".deleteEmplpyeetimesheet", function () {
            var employeeTimeSheet_id = $(this).data('id');
            $("input[name=employeetimesheet_id]").val(employeeTimeSheet_id);
        });

        function removeEmployeetimesheet() {
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
            var employeeTimeSheet_id = $("input[name=employeetimesheet_id]").val();
            $.ajax({
                type: 'POST',
                url: '/employeetimesheet/' + employeeTimeSheet_id,
                data: {_method: 'delete'},
                statusCode: {
                    200: function (response) {
                        // console.log(result);
                        // console.log(result.responseText);
                        toastr["success"]("ساعت کاری با موفقیت حذف شد!", "پیام سیستم");
                        $("#filterButton").trigger("click");
                    },
                    //The status for when the user is not authorized for making the request
                    401: function (ressponse) {
                        location.reload();
                    },
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        //
                    },
                    //The status for when there is error php code
                    500: function (response) {
//                        console.log(response.responseText);
//                        toastr["error"]("خطای برنامه!", "پیام سیستم");
                    },
                    //The status for when there is error php code
                    503: function (response) {
//                        toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                    }
                }
            });
        }

        @endpermission
    </script>
@endsection