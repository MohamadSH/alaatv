@extends("app" , ["pageName"=>"productsPortfolio"])

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("pageBar")
    {{--<h3 class="page-title"> محصولات--}}
    {{--<small>اردوی طلایی </small>--}}
    {{--</h3>--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
    {{--<img src="/img/extra/landing/hamayesh-ad.jpg">--}}
    {{--</div>--}}
    {{--</div>--}}
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>محصولات</span>
            </li>

        </ul>
    </div>
@endsection

@section("title")
    <title>محصولات|آلاء</title>
@endsection

@section("content")
    {{--<a href="{{action("ProductController@showLive" , 183)}}"><img src="/img/extra/arabi-live-ad.jpg" width="100%"></a>--}}
    <div class="portfolio-content portfolio-1">
        @if($products->isEmpty())
            <div class="note " style="background-color: #00d4db;">
                <h4 class="block bold" style="text-align: center">کاربر گرامی در حال حاضر موردی برای ثبت نام وجود ندارد.
                    همایشها و اردوهای بعدی به زودی اعلام خواهند شد.</h4>
            </div>
        @else
            @include("partials.portfolioGrid" , ["withFilterButton" => true , "withAd"=>true])
        @endif
        <div class="cbp-l-loadMore-button margin-top-40" id="pagination-div">
            <div class="search-page">
                <div class="search-pagination">
                    <ul class="pagination">
                        {{ $products->links() }}
                    </ul>

                </div>
            </div>

        </div>
    </div>
    {{--<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">--}}
    {{--<div class="modal-dialog">--}}
    {{--<div class="modal-content">--}}
    {{--<div class="modal-header">--}}
    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>--}}
    {{--<h4 class="modal-title font-green">به آلاء خوش آمدید</h4>--}}
    {{--</div>--}}
    {{--<div class="modal-body bold">--}}
    {{--@if(Session::has('welcomePasswordMessage'))--}}
    {{--<div class="row" id="passwordMessageRow">--}}
    {{--<div class="col-md-12">--}}
    {{--<h3 class="font-red">رمز عبور شما</h3>--}}
    {{--<p style="text-align: justify;">--}}
    {{--</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--@if(Session::has('welcomeVerifyCodeMessage'))--}}
    {{--<div class="row" id="verifyCodeMessageRow">--}}
    {{--<div class="col-md-12">--}}
    {{--<h3 class="font-red">تایید شماره موبایل(تایید حساب کاربری)</h3>--}}
    {{--<p style="text-align: justify;">--}}
    {{--</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--<div class="row" >--}}
    {{--<div class="col-md-12">--}}
    {{--<a href="{{action("UserController@show",Auth::user())}}" class="btn btn-lg blue">--}}
    {{--<i class="icon-user"></i> رفتن به پروفایل </a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="modal-footer">--}}
    {{--<button type="button" class="btn dark btn-outline" data-dismiss="modal">بستن پنجره</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<!-- /.modal-content -->--}}
    {{--</div>--}}
    {{--<!-- /.modal-dialog -->--}}
    {{--</div>--}}
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    {{--<script src="/assets/pages/scripts/portfolio-1.min.js" type="text/javascript"></script>--}}
    {{--I have put the customized code in extraJS section--}}
@endsection

@section("extraJS")
    <script type="text/javascript">
        {{--$(window).bind("load", function() {--}}
                {{--@if (Session::has('welcomePasswordMessage') || Session::has('welcomeVerifyCodeMessage') )--}}
                {{--$("#passwordMessageRow > div > p").html("{{Session::pull('welcomePasswordMessage')}}");--}}
                {{--$("#verifyCodeMessageRow > div > p").html("{{Session::pull('welcomeVerifyCodeMessage')}}");--}}
                {{--$("#welcomeMessage").trigger("click");--}}
                {{--@endif--}}
                {{--});--}}
        (function ($, window, document, undefined) {
            'use strict';

            // init cubeportfolio
            $('#js-grid-juicy-projects').cubeportfolio({
                filters: '#js-filters-juicy-projects',
                loadMore: '#js-loadMore-juicy-projects',
                loadMoreAction: 'click',
                layoutMode: 'grid',
                defaultFilter: '*',
                animationType: 'quicksand',
                gapHorizontal: 35,
                gapVertical: 30,
                gridAdjustment: 'responsive',
                mediaQueries: [{
                    width: 1500,
                    cols: 5
                }, {
                    width: 1100,
                    cols: 4
                }, {
                    width: 800,
                    cols: 3
                }, {
                    width: 480,
                    cols: 2
                }, {
                    width: 320,
                    cols: 1
                }],
                caption: 'overlayBottomReveal',
                displayType: 'sequentially',
                displayTypeSpeed: 80,

                // lightbox
                lightboxDelegate: '.cbp-lightbox',
                lightboxGallery: true,
                lightboxTitleSrc: 'data-title',
                lightboxCounter: '<div class="cbp-popup-lightbox-counter" style="direction:ltr">@{{current}} of @{{total}}</div>',

                // singlePage popup
                singlePageDelegate: '.cbp-singlePage',
                singlePageDeeplinking: true,
                singlePageStickyNavigation: true,
                singlePageCounter: '<div class="cbp-popup-singlePage-counter" style="direction:ltr">@{{current}} of @{{total}}</div>',
                singlePageCallback: function (url, element) {
                    // to update singlePage content use the following method: this.updateSinglePage(yourContent)
                    var t = this;

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'html',
                        timeout: 10000
                    })
                        .done(function (result) {
                            t.updateSinglePage(result);
                        })
                        .fail(function () {
                            t.updateSinglePage('AJAX Error! Please refresh the page!');
                        });
                },
            });

        })(jQuery, window, document);
    </script>
@endsection