@extends("app")

@section("content")
    <!-- BEGIN LOGO -->
    <div class = "logo">
        <a href = "{{route('web.index')}}">
            <img src = "/assets/pages/img/logo-big.png" alt = "ثبت نام"/>
        </a>
    </div>
    <!-- END LOGO -->
    <div class = "content">
        @include("user.form"  , ["formID" => 1])
    </div>
    <!-- BEGIN COPYRIGHT -->
    <div class = "copyright" style = "direction: ltr;"> 2017 &copy; Alaa</div>
    <!-- END COPYRIGHT -->
@endsection
