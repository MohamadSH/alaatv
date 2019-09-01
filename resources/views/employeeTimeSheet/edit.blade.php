@extends('app')

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
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
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
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
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
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
