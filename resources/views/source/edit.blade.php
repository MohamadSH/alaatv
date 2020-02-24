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
                <a class="m-link" href="#">اصلاح منبع</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    {{--Ajax modal loaded after inserting content--}}
    <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
    {{--Ajax modal for panel startup --}}

    <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-plus"></i>
                            </span>
                    <h3 class="m-portlet__head-text">
                        درج منبع جدید
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            {!! Form::model($source,['files'=>true , 'method'=>'PUT' , 'url'=>route('source.update' , $source) , 'accept-charset'=>'UTF-8']) !!}
            @include('source.form')
            <hr>
            <button type="submit" class="btn btn-info">ذخیره</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('page-js')
@endsection
