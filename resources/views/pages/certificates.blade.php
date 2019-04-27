@extends("app",["pageName"=>"certificates"])

@section('right-aside')
@endsection


@section("pageBar")
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                مجوزها
            </li>
        </ol>
    </nav>
@endsection

@section("content")
    @include("partials.certificates");
@endsection

