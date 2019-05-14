@permission((Config::get('constants.EDIT_EMPLOPYEE_WORK_SHEET')))

@extends('app')

@section('page-css')
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/icheck/skins/all.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css" rel = "stylesheet" type = "text/css"/>
    <style>
        .datepicker-header {
            direction: ltr;
        }
    </style>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">
                    اصلاح ساعت کاری
                    @if(isset($employeetimesheet)) {{$employeetimesheet->getEmployeeFullName()}} @endif
                </a>
            </li>
        </ol>
    </nav>
@endsection

@section("content")
    
    @include("systemMessage.flash")
    
    <div class = "row">
        <div class = "col-md-12">
            <div class = "m-portlet m-portlet--mobile">
                <div class = "m-portlet__body">
                    {!! Form::model($employeetimesheet, ['method' => 'PUT','action' => ['Web\EmployeetimesheetController@update',$employeetimesheet] , 'class'=>'form-horizontal' ,'accept-charset'=>'UTF-8' , 'enctype'=>'multipart/form-data']) !!}
                    @include('employeeTimeSheet.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-js')
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.min.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/lib/persian-date.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery.input-ip-address-control-1.0.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/icheck/icheck.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-editors.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/app.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/form-input-mask.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/form-icheck.js" type = "text/javascript"></script>
    
    <script type="text/javascript">
        jQuery(document).ready(function () {
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
    
    
            $("#filterButton").trigger("click");
        });
    
    </script>
@endsection
@endpermission
