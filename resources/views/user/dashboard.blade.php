@extends("app" , ["pageName"=>$pageName])

@section('right-aside')
@endsection
@section("pageBar")
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item">
                <i class = "flaticon-user"></i>
                <a href = "{{ action("Web\UserController@show",[$user]) }}">@lang('page.Profile')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                داشبورد
            </li>
        </ol>
    </nav>
@endsection

@section("content")
    <div>
        {{ dump($user) }}
        {{ dump($userAssetsCollection) }}
    </div>
@endsection