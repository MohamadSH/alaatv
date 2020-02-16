@extends('partials.templatePage',["pageName"=>"certificates"])

@section('right-aside')
@endsection


@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home"></i>
                <a href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                مجوزها
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    @include('partials.certificates');
@endsection

