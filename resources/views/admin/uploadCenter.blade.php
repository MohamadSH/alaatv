@extends('app')

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">آپلود سنتر</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    {{--Ajax modal loaded after inserting content--}}
    <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
    {{--Ajax modal for panel startup --}}

    <div class = "alert alert-info alert-dismissible fade show" role = "alert" id="uploadedFileMessage" style="display:none">
        <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close"></button>
        <strong>
                آدرس فایل شما: <br>
            <span id="uploadedFilePath"></span>
        </strong>
    </div>
    @permission((config('constants.SEND_SMS_TO_USER_ACCESS')))
    <div class="row" id="smsLinkPortlet" style="display:none">
        <div class="col-lg-4 mx-auto">
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                لینک را پیامک کن
                            </h3>
                        </div>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    {!! Form::open([ 'method'=>'POST' , 'url'=>route('web.sms.link') , 'accept-charset'=>'UTF-8' , 'id' =>'smsLinkForm' ]) !!}
                    <div class = "form-group">
                        {!! Form::input('hidden','link' , null , ['id' => 'smsLink']) !!}
                        {!! Form::select('employee_id', $employees ,null , ['id' => 'employee' , 'class' => 'mt-multiselect btn btn-default a--full-width' , 'data-label' => 'left' , 'data-width' => '100%' , 'data-filter'=>'true' , 'data-height'=>'200', 'title'=>'ارسال به']) !!}
                        {!! Form::submit('بفرست' , ['class' => 'btn btn-success a--full-width']) !!}
                    </div>
                    <div class = "form-group" style="text-align: center">
                        <img src="https://cdn.alaatv.com/upload/alaaLoading-small.gif" id="sending" style="display:none">
                    </div>
                    @if ($errors->has('employee'))
                        <hr>
                        <div class = "form-group has-danger">
                            <span class="form-control-feedback">
                                        <strong>{{ $errors->first('employee') }}</strong>
                            </span>
                        </div>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @endpermission

    <div class="row">
        <div class="col-lg-4 mx-auto">
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-file"></i>
                            </span>
                    <h3 class="m-portlet__head-text">
                        آپلود فایل
                    </h3>
                </div>
            </div>
        </div>
        <div class = "m-portlet__body">
            <ul class="font-weight-bold m--font-info">
                <li>
                فرمت های مجاز فایل : pdf, png, jpg
                </li>
                <li>
                حداکثر حجم مجاز: 100 مگ
                </li>
            </ul>
            <hr>
            {!! Form::open(['files'=>true , 'method'=>'POST' , 'url'=>'/big' , 'accept-charset'=>'UTF-8' , 'id' =>'uploadForm' ]) !!}
            <div class = "form-group" style="text-align: center">
                {!! Form::file('file' , ['id' => 'file']) !!}
                {!! Form::submit('آپلود' , ['class' => 'btn btn-primary a--full-width']) !!}
            </div>
            <div class = "form-group" style="text-align: center">
                <img src="https://cdn.alaatv.com/upload/alaaLoading-small.gif" id="loading" style="display:none">
            </div>
            @if ($errors->has('file'))
                <hr>
                <div class = "form-group has-danger">
                    <span class="form-control-feedback">
                                <strong>{{ $errors->first('file') }}</strong>
                    </span>
                </div>
            @endif
            {!! Form::close() !!}
        </div>
    </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script>
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

        $(document).on('submit', '#uploadForm', function (e) {
            e.preventDefault();
            $('#loading').show();
            $('#uploadedFileMessage').hide();
            $('#uploadedFilePath').html('');
            if ( $( '#smsLink' ).length ) {
                $('#smsLink').val('');
            }
            if ( $( '#smsLinkPortlet' ).length ) {
                $('#smsLinkPortlet').hide();
            }

            var form = $(this);
            var datastring = new FormData($(this)[0]);
            url = form.attr('action');
            var fileName = $('#file').val().split('\\').pop();

            $.ajax({
                type: 'POST',
                url: url,
                data: datastring,
                headers:{
                    'X-Datatype' : 'uploadCenterSftp',
                    'X-Dataname' : fileName,
                },
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        var link = response.link;
                        toastr["success"]("محتوا با موقیت درج شد", "پیام سیستم");
                        form[0].reset();
                        $('#uploadedFileMessage').show();
                        $('#uploadedFilePath').html('<a href="'+link+'">'+link+'</a>');
                        if ( $( '#smsLink' ).length ) {
                            $('#smsLink').val(link);
                        }
                        if ( $( '#smsLinkPortlet' ).length ) {
                            $('#smsLinkPortlet').show();
                        }
                        $('#loading').hide();
                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        toastr["warning"]("دسترسی غیرمجاز", "خطای 403");
                        $('#loading').hide();
                    },
                    404: function (response) {
                        toastr["warning"]("آدرس مورد نظر یافت نشد", "خطای 404");
                        $('#loading').hide();
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        toastr["error"]("ورودی های غیرمجاز", "خطای 422");
                        $('#loading').hide();
                    },
                    //The status for when there is error php code
                    500: function (response) {
                        toastr["error"]("خطای سرور", "خطای 500");
                        $('#loading').hide();
                        console.log(response.response);
                    },
                    503: function (response) {
                        toastr["error"]("سرویس خارج از دسترس", "خطای 503");
                        $('#loading').hide();
                        console.log(response.response);
                    },
                    301: function (response) {
                        toastr["error"]("آدرس مورد نظر ریدایرکت شده است", "خطای 301");
                        $('#loading').hide();
                    },
                },
                cache: false,
                contentType: false,
                processData: false
            });

        });

        @permission((config('constants.SEND_SMS_TO_USER_ACCESS')))
        $(document).on('submit', '#smsLinkForm', function (e) {
            e.preventDefault();
            $('#sending').show();

            var form = $(this);
            var datastring = new FormData($(this)[0]);
            url = form.attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: datastring,
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        toastr["success"]("پیامک با موفقیت ارسال شد", "پیام سیستم");
                        form[0].reset();
                        $('#sending').hide();
                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        toastr["warning"]("دسترسی غیرمجاز", "خطای 403");
                        $('#sending').hide();
                    },
                    404: function (response) {
                        toastr["warning"]("آدرس مورد نظر یافت نشد", "خطای 404");
                        $('#sending').hide();
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        toastr["error"]("ورودی های غیرمجاز", "خطای 422");
                        $('#sending').hide();
                    },
                    //The status for when there is error php code
                    500: function (response) {
                        toastr["error"]("خطای سرور", "خطای 500");
                        $('#sending').hide();
                        console.log(response.response);
                    },
                    503: function (response) {
                        toastr['error']("سرویس خارج از دسترس", "خطای 503");
                        $('#sending').hide();
                        console.log(response.response);
                    },
                    301: function (response) {
                        toastr["error"]("آدرس مورد نظر ریدایرکت شده است", "خطای 301");
                        $('#sending').hide();
                    },
                },
                cache: false,
                contentType: false,
                processData: false
            });

            return false;
        });
        @endpermission
    </script>
@endsection
