@extends("app")
@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("pageBar")

@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered ">
                {{--<div class="portlet-title">--}}
                {{--<div class="caption">--}}
                {{--<i class=" icon-layers font-green"></i>--}}
                {{--<span class="caption-subject font-green bold uppercase"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="portlet-body">
                    <div class="row">
                        @include("partials.checkoutSteps" , ["step"=>0])
                    </div>
                    <div class="row">
                        {{--<a  data-toggle="modal" href="#sign-in" id="signin-button">--}}
                                    {{--<div class="col-xs-12 col-md-4 btn bg-blue font-white bold text-center">--}}
                                        {{--<!-- BEGIN PORTLET-->--}}
                                                    {{--<h4 class="block"><i class="fa fa-sign-in fa-2x"></i></h4>--}}
                                                    {{--<h3 class="bold" >--}}
                                                        {{--قبلا عضو شده اید؟--}}
                                                    {{--</h3>--}}
                                                    {{--<h4 class="bold">برای ورود کلیک کنید</h4>--}}
                                                {{--<!-- Your custom menu with dropdown-menu as default styling -->--}}
                                        {{--<!-- END PORTLET-->--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                        {{--<div id="sign-in" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">--}}
                            {{--<div class="modal-dialog">--}}
                                {{--<div class="modal-content">--}}
                                    {{--<div class="modal-header">--}}
                                        {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>--}}
                                        {{--<h4 class="modal-title">ورود</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-body">--}}
                                        {{--@include("partials.loginForm")--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-footer">--}}
                                        {{--<button type="button" data-dismiss="modal" class="btn dark btn-outline">بستن</button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<a  data-toggle="modal" href="#sign-up" id="signup-button">--}}
                                    {{--<div class="col-xs-12 col-md-4 btn bg-green font-white bold text-center">--}}
                                        {{--<!-- BEGIN PORTLET-->--}}
                                            {{--<h4 class="block"><i class="fa fa-lock fa-2x"></i></h4>--}}
                                            {{--<h3 class="bold" >--}}
                                                {{--تازه وارد هستید؟--}}
                                            {{--</h3>--}}
                                            {{--<h4 class="bold">برای ثبت نام کلیک کنید</h4>--}}
                                        {{--<!-- Your custom menu with dropdown-menu as default styling -->--}}
                                        {{--<!-- END PORTLET-->--}}
                                    {{--</div>--}}
                                {{--</a>--}}
                        {{--<div id="sign-up" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">--}}
                            {{--<div class="modal-dialog">--}}
                                {{--<div class="modal-content">--}}
                                    {{--<div class="modal-header">--}}
                                        {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>--}}
                                        {{--<h4 class="modal-title">ثبت نام</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-body">--}}
                                        {{--@include("user.form"  , ["formID"=>2 , "pageName"=>"checkoutAuth"])--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-footer">--}}
                                        {{--<button type="button" data-dismiss="modal" class="btn dark btn-outline">بستن</button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            @include("partials.loginForm")
                        </div>

                    </div>
                    <br/>
                    <br/>
                    <br/>

                </div>
            </div>
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="{{ mix('/js/footer_Page_Level_Plugin.js') }}" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="{{ mix('/js/Page_Level_Script_all.js') }}" type="text/javascript"></script>
@endsection

@section("extraJS")
    @if(!empty($errors->getBags()))
        <script>
            jQuery(document).ready(function() {
                @if(!$errors->login->isEmpty())
                    $("#signin-button").trigger("click");
                @else
                    $("#signup-button").trigger("click");
                @endif
            });
        </script>
    @endif
@endsection