@extends('app')

@section("headPageLevelStyle")
    <link href="/assets/pages/css/login-4-rtl.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section("headThemeLayoutStyle")

@endsection

@section("header")
@endsection
@section("sidebar")
@endsection
@section("themePanel")
@endsection
@section("pageBar")
@endsection
@section('content')


    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
						</span>
                    <h3 class="m-portlet__head-text">
                        تکمیل ثبت نام
                    </h3>
                </div>
            </div>
        </div>

        @include("user.form", ["formID"=>1 , "noteFontColor"=>"m--font-brand" , "hasHomeButton"=>1])

    </div>


@endsection

@section("footer")

@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/login-4.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
@endsection
