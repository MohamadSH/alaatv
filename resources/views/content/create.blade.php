@permission((Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS')))@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-summernote/summernote.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel = "stylesheet" type = "text/css"/>
    <style>
        .datepicker-header {
            direction: ltr;
        }
    </style>
@endsection


@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{route('web.index')}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <a href = "{{action("Web\AdminController@adminContent")}}">پنل مدیریتی</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>درج محتوای آموزشی</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-3"></div>
        <div class = "col-md-8">
            @include("systemMessage.flash")
            @if(!$errors->isEmpty())
                <div class = "custom-alerts alert alert-warning fade in margin-top-10">
                    <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true"></button>
                    <i class = "fa fa-exclamation-triangle"></i>
                    لطفا خطاهای ورودی را بطرف نمایید
                </div>
            @endif
            {!! Form::open(['files'=>true,'method' => 'POST','action' => 'ContentController@store', 'class'=>'form-horizontal']) !!}
            @include('content.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-summernote/summernote.min.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/lib/persian-date.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/select2/js/select2.full.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/components-editors.min.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type = "text/javascript"></script>
    <script src = "/assets/pages/scripts/form-input-mask.min.js" type = "text/javascript"></script>
    <script src = "/assets/pages/scripts/components-bootstrap-multiselect.min.js" type = "text/javascript"></script>
@endsection


@section("extraJS")
    <script src = "/js/extraJS/scripts/admin-makeMultiSelect.js" type = "text/javascript"></script>
    <script>
        $('#descriptionSummerNote').summernote({height: 300});

        function setContentTypeSelectStatus() {
            var selected = $("#rootContentTypes option:selected").text();
            if (selected == "آزمون") {
                $("#childContentTypes").prop("disabled", false);
            } else {
                $("#childContentTypes").prop("disabled", true);
            }
        }

        setContentTypeSelectStatus();

        $(document).ready(function () {
            $('#rootContentTypes').on('change', function () {
                setContentTypeSelectStatus();
            });

            /*
             validdSince
             */
            $("#validSinceDate").persianDatepicker({
                altField: '#validSinceDateAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });

            $("#validSinceTime").inputmask("hh:mm", {
                placeholder: "",
                clearMaskOnLostFocus: true
            });

//            Inputmask("\\http://{+}").mask("#cloudFile");
        });
    </script>
@endsection
@endpermission
