@extends("app")

@section('pageBar')

    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item">
                <a class = "m-link" href = "{{route('web.admin.content')}}">مدیریت محتوا</a>
            </li>
            <li class = "breadcrumb-item">
                <a class = "m-link" href = "{{route('section.index')}}">لیست سکشن ها</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">اصلاح سکشن {{$section->name}}</a>
            </li>
        </ol>
    </nav>

@endsection

@section("content")
    @include("systemMessage.flash")
    <div class="m-portlet m-portlet--tabs productDetailes">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    اصلاح سکشن {{$section->name}}
                </div>
            </div>
            <div class="m-portlet__head-tools">
            </div>
        </div>

        <div class="m-portlet__body">
            {!! Form::model( $section , ['method'=>'PUT' , 'url'=>route('section.update' , $section)]) !!}
                @include('content.section.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection

