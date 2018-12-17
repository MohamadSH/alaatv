@extends("app")

@section("headPageLevelStyle")
    <link href="/assets/pages/css/error-rtl.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section("headThemeLayoutStyle")

@endsection
@section('title')
    <title>Error</title>
@show
@section("header")
@endsection

@section("themePanel")
@endsection

@section("sidebar")
@endsection

@section("pageBar")
@endsection
@section("bodyClass")
    class="page-500-full-page"
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12 page-500">
            <div class=" number font-red"> 500</div>
            <div class=" details">
                {{--<h3>با عرض پوزش خطایی غیر منتظره رخ داده است!</h3>--}}
                {{--<p> تیم ما در حال برطرف کردن این خطا می باشند . لطفا چند دقیقه دیگر دوباره اقدام خود را تکرار کنیید--}}
                {{--<br/> </p>--}}
                <p>
                    <a href="{{action("HomeController@index")}}" class="btn red btn-outline"> @lang('page.Home') </a>
                    <br></p>
            </div>
        </div>
    </div>
@endsection
@section("footer")
@endsection

@section("footerThemeLayoutScript")
@endsection
