@extends("app",["pageName"=>"certificates"])

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>مجوزها</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    @include("partials.certificates");
@endsection

