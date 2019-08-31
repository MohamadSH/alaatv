@extends("app")

@section("headPageLevelStyle")
    <link href = "/assets/pages/css/error-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection
@section("headThemeLayoutStyle")

@endsection

@section("title")
    <title>Access Denied</title>
@endsection
@section("bodyClass")
    class="page-404-full-page"
@endsection

@section("header")
@endsection

@section("themePanel")
@endsection

@section("sidebar")
@endsection

@section("pageBar")
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-12 page-404">
            <div class = "number">
                <img src = "/acm/extra/stop.png" style = "">
            </div>
            {{--<div class="number m--font-danger"> 404 </div>--}}
            <div class = "details">
                {{--<h1 class="m--font-danger">خطا!</h1>--}}
                <p class = "bold "> {!!    $message !!}
                    <br/>
                    <a class = "btn green" href = "{{route('web.index')}}"> صفحه اصلی</a>
                {{--or try the search bar below. </p>--}}
                {{--<form action="#">--}}
                {{--<div class="input-group input-medium">--}}
                {{--<input type="text" class="form-control" placeholder="keyword...">--}}
                {{--<span class="input-group-btn">--}}
                {{--<button type="submit" class="btn red">--}}
                {{--<i class="fa fa-search"></i>--}}
                {{--</button>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--<!-- /input-group -->--}}
                {{--</form>--}}
            </div>
        </div>
    </div>
@endsection

@section("footer")
@endsection

@section("footerThemeLayoutScript")
@endsection
