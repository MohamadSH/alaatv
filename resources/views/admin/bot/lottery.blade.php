@extends("app",["pageName"=>$pageName])

@section("headPageLevelPlugin")

@endsection

@section("metadata")
    @parent()
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>بات</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    {{--Ajax modal loaded after inserting content--}}
    <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
    {{--Ajax modal for panel startup --}}
    <div class="row">
        @include("systemMessage.flash")
        <div class="col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-body">
                    {{(isset($params["pointGiven"]) && $params["pointGiven"])?"✅":""}}<span class="bold"
                                                                                            style="font-size: larger">1.</span>&nbsp;&nbsp;<a class = "btn btn-default" href = "{{action("Web\HomeController@pointBot")}}"
                                                                                                                                              {{(isset($params["pointGiven"]) && $params["pointGiven"])?"disabled":""}} target="_blank">اهدای
                        امتیاز به کاربران</a>
                    <hr>
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")

@endsection

@section("footerPageLevelScript")

@endsection

@section("extraJS")

@endsection
