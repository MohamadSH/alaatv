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
            {!! Form::open(['files'=>true , 'method'=>'POST' , 'url'=>route('web.upload') , 'accept-charset'=>'UTF-8' ]) !!}
            <div class = "form-group">
                {!! Form::file('file') !!}
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
@endsection
