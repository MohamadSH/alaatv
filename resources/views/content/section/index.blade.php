@extends('partials.templatePage')

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
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">لیست سکشن ها</a>
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
                    افزودن سکشن
                </div>
            </div>
            <div class="m-portlet__head-tools">
            </div>
        </div>

        <div class="m-portlet__body">
            {!! Form::open(['method'=>'POST' , 'url'=>route('section.store')]) !!}
                @include('content.section.form')
            {!! Form::close() !!}
        </div>
    </div>
    <div class="m-portlet m-portlet--tabs productDetailes">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    لیست سکشن های کانتنت
                </div>
            </div>
            <div class="m-portlet__head-tools">
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th> نام</th>
                        {{--                                <th>ترتیب</th>--}}
                        <th>فعال</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($sections))
                        @foreach($sections as $section )
                            <tr>
                                <td>
                                    <a target="_blank" href="{{route('section.edit' , $section->id)}}">{{ $section->id }}</a>
                                </td>
                                <td> {{ $section->name }}</td>
                                <td>{{($section->enable)?'بله':'خیر'}}</td>
                                <td>
                                    <a target="_blank" class="btn btn-accent"  href="{{route('section.edit' , $section->id)}}">اصلاح</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

