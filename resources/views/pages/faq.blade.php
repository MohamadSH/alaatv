@extends('partials.templatePage' , ["pageName"=>$pageName])

@section('page-css')
{{--    <link href="{{ mix('/css/page-shop.css') }}" rel="stylesheet" type="text/css"/>--}}
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home"></i>
                <a href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                سوالات متداول
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include('systemMessage.flash')


@endsection

@section('page-js')
{{--    <script src="{{ mix('/js/page-shop.js') }}" defer></script>--}}
@endsection

