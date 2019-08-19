@extends('app')

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">بات</a>
            </li>
        </ol>
    </nav>
@endsection

@section("content")
    {{--Ajax modal loaded after inserting content--}}
    <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
    {{--Ajax modal for panel startup --}}

    @include("systemMessage.flash")

    <div class = "row">
        <div class = "col">
            <!-- BEGIN Portlet PORTLET-->

            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__body">
                    {{(isset($params["pointGiven"]) && $params["pointGiven"])?"✅":""}}
                    <span class = "bold" style = "font-size: larger">
                        1.
                    </span> &nbsp;&nbsp;
                    <a class = "btn btn-default" href = "{{action("Web\BotsController@pointBot")}}" {{(isset($params["pointGiven"]) && $params["pointGiven"])?"disabled":""}} target = "_blank">
                        اهدای امتیاز به کاربران
                    </a>
                    <hr>
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>
@endsection
