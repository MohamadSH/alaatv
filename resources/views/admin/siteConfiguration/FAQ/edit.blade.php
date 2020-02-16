@extends('partials.templatePage')

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پیکربندی سایت</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col">

            @include("systemMessage.flash")

            {!! Form::open(['files' => true , 'method' => 'POST' , 'url' => [route('web.setting.faq.update' , $setting)] , 'class'=>'form-horizontal']) !!}
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                افزودن سؤال
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    @include('admin.siteConfiguration.FAQ.form')
                    {!! Form::submit('ذخیره' , ['class' => 'btn m-btn--pill btn-success m--margin-left-15']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('page-js')
@endsection
