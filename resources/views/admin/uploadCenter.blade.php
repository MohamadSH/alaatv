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

    @include("systemMessage.flash")

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
            {!! Form::open(['files'=>true , 'method'=>'POST' , 'url'=>route('web.bigUpload') , 'accept-charset'=>'UTF-8' , 'id' =>'uploadForm' ]) !!}
            <div class = "form-group">
                {!! Form::file('file' , ['id' => 'file']) !!}
                {!! Form::submit('آپلود' , ['class' => 'btn btn-primary']) !!}
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
        $(document).on('submit', '#uploadForm', function (e) {
            e.preventDefault();
            // var loadingImage = "<img src = '/acm/extra/loading-arrow.gif' style='height: 20px;'>";
            var form = $(this);
            var datastring = new FormData($(this)[0]);
            url = form.attr('action');
            var fileName = $('#file').val().split('\\').pop();
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
                        // console.log(response);
                        // console.log(response.responseText);
                        toastr["success"]("محتوا با موقیت درج شد", "پیام سیستم");
                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        toastr["error"]("خطای ۴۲۲ . خطای ورودی ها", "پیام سیستم");
                    },
                    //The status for when there is error php code
                    500: function (response) {
                        console.log(response.responseText);
                    },
                    //The status for when there is error php code
                    503: function (response) {
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        });
    </script>
@endsection