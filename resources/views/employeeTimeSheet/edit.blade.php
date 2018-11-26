@permission((Config::get('constants.EDIT_EMPLOPYEE_WORK_SHEET')))
@extends("app")

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet"
          type="text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css"/>
    <style>
        .datepicker-header {
            direction: ltr;
        }
    </style>
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span> اصلاح ساعت کاری @if(isset($employeetimesheet)) {{$employeetimesheet->getEmployeeFullName()}} @endif</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">
            @include("systemMessage.flash")
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="row">
                        {!! Form::model($employeetimesheet, ['method' => 'PUT','action' => ['EmployeetimesheetController@update',$employeetimesheet] , 'class'=>'form-horizontal' ,'accept-charset'=>'UTF-8' , 'enctype'=>'multipart/form-data']) !!}
                        @include('employeeTimeSheet.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"
            type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/components-editors.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js"
            type="text/javascript"></script>
    <script src="/assets/pages/scripts/form-input-mask.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
@endsection


@section("extraJS")
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