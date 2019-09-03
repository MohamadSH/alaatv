@role((Config::get("constants.ROLE_ADMIN")))

@extends('app',['pageName'=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">پنل مدیریت قرعه کشی</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include("systemMessage.flash")

    <div class = "row">
        <div class = "col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__body">
                    <span class = "bold" style = "font-size: larger"></span>&nbsp;&nbsp;
                    <a class = "btn btn-default" href = "{{action("Web\BotsController@pointBot")}}?15tir" {{($pointsGiven)?"disabled":""}} target = "_blank">
                        اهدای امتیاز
                    </a>
{{--                    <a class = "btn btn-default" href = "{{action("Web\BotsController@pointBot")}}?riyazi" {{($pointsGiven)?"disabled":""}} target = "_blank">--}}
{{--                        اهدای امتیاز اضافه ریاضی--}}
{{--                    </a>--}}
{{--                    <a class = "btn btn-default" href = "{{action("Web\BotsController@pointBot")}}?tajrobi" {{($pointsGiven)?"disabled":""}} target = "_blank">--}}
{{--                        اهدای امتیاز اضافه تجربی--}}
{{--                    </a>--}}
                    <span class = "m--font-danger bold">{{($pointsGiven)?"اهدا شده است":""}}</span>
                    <hr>
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12">

            @role((Config::get("constants.ROLE_ADMIN")))
            <!-- BEGIN ROLE TABLE PORTLET-->

            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-" id = "lottery-portlet">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                <i class = "fa fa-cogs m--margin-right-10"></i>
                                برندگان قرعه کشی {{$lotteryDisplayName}}
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <ul class = "m-portlet__nav">
                            <li class = "m-portlet__nav-item">
                                <a href = "" class = "m-portlet__nav-link m-portlet__nav-link--icon">
                                    <img class = "hidden" id = "product-portlet-loading" src = "{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt = "loading" style = "width: 50px;">
                                </a>
                            </li>
                            <li class = "m-portlet__nav-item">
                                <a href = "javascript:" class = "m-portlet__nav-link m-portlet__nav-link--icon collapse" id = "lottery-expand">
                                    <i class = "fa fa-redo"></i>
                                </a>
                            </li>
                            <li class = "m-portlet__nav-item">
                                <a href = "javascript:" class = "m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class = "fa fa-redo"></i>
                                </a>
                            </li>
                            <li class = "m-portlet__nav-item">
                                <a href = "javascript:" class = "m-portlet__nav-link m-portlet__nav-link--icon remove">
                                    <i class = "fa fa-angle-down"></i>
                                </a>
                            </li>
                        </ul>

                        <img class = "hidden" id = "lottery-portlet-loading" src = "{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}" alt = "loading" style = "width: 50px;">
                    </div>
                </div>
                <div class = "m-portlet__body">

                    <div class = "table-toolbar">
                        <div class = "row">
                            <div class = "col-md-6">
                                <div class = "btn-group">
                                    @if(isset($userlotteries) && $userlotteries->isEmpty())
                                        <a href = "{{action("Web\LotteryController@holdLottery" , ["lottery"=>$lotteryName])}}" class = "btn m-btn--pill m-btn--air btn-outline-primary" target = "_blank">
                                            برگزاری قرعه کشی
                                        </a>
                                    @else
                                        <a href = "{{action("Web\LotteryController@givePrizes", ["lottery"=>$lotteryName])}}" class = "btn btn-outline red" target = "_blank">
                                            اهدای جوایز
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class = "table table-striped table-bordered table-hover dt-responsive" width = "100%" id = "lottery_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class = "all"> رتبه برنده</th>
                            <th class = "all"> نام</th>
                            <th class = "all"> موبایل</th>
                            <th class = "all"> جایزه</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userlotteries as $userlottery)
                            <tr>
                                <td></td>
                                <td>{{$userlottery->pivot->rank}}</td>
                                <td>
                                    <a href = "{{action("Web\UserController@edit", $userlottery)}}" target = "_blank">{{$userlottery->full_name}}</a>
                                </td>
                                <td>{{$userlottery->mobile}}</td>
                                <td>
                                    @if(isset($userlottery->pivot->prizes))
                                        {{--                                         {{dd(json_decode($userlottery->pivot->prizes))}}--}}
                                        @if(isset(json_decode($userlottery->pivot->prizes)->items))
                                            @foreach(json_decode($userlottery->pivot->prizes)->items as $item )
                                                <p class = "text-center bold">{{$item->name}}</p>
                                            @endforeach
                                        @else
                                            جایزه ای داده نشده
                                        @endif
                                    @else
                                            جایزه نال است
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->@endrole
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script type = "text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
        @role((Config::get("constants.ROLE_ADMIN")));
            var newDataTable = $("#lottery_table").DataTable();
            newDataTable.destroy();
            makeDataTable("lottery_table");
            $("#lottery-expand").trigger("click");
        @endrole
        });
    </script>
@endsection
@endrole
