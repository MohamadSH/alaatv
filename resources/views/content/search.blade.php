@extends('partials.templatePage')

@section("css")
    <link rel = "stylesheet" href = "{{ mix('/css/all.css') }}">
    <style>
        .mt-element-list {
            background-color: white;
        }

    </style>
@endsection

@section("title")
    <title>آلاء|محتوای آموزشی|جزوه|آزمون</title>
@endsection

@section("pageBar")

@endsection

@section("bodyClass")
    class = "page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("content")

    <div class = "row">
        <div class = "col-md-4">
            <div class = "portlet light ">
                {{--<div class="portlet-title">--}}
                {{--<div class="caption">--}}
                {{--فیلتر--}}
                {{--</div>--}}
                {{--<div class="tools"> </div>--}}

                {{--</div>--}}
                <div class = "portlet-body">
                    {!! Form::open(['action'=> 'ContentController@index'  ,'class'=>'form-horizontal form-row-seperated' , 'id' => 'contentFilterForm'  ]) !!}
                    <div class = "form-body">
                        <div class = "form-group form-md-line-input has-info form-md-floating-label">
                            <div class = "col-md-12">
                                <div class = "input-group input-group-sm">
                                    <div class = "input-group-control">
                                        <input name = "searchText" type = "text" class = "form-control input-sm" id = "searchText">
                                        <label for = "searchText">متن جستجو</label>
                                    </div>
                                    <span class = "input-group-btn btn-right">
                                            <button class = "btn green-haze" type = "button" id = "goButton">بگرد!</button>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class = "form-group form-md-line-input form-md-floating-label has-info">
                            <div class = "col-md-12">
                                @include('admin.filters.gradeFilter', [
                                     "dropdown"=>true ,
                                     'dropdownClass'=>'contentFilter'
                                  ])
                            </div>
                        </div>
                        <div class = "form-group form-md-line-input form-md-floating-label has-info">
                            <div class = "col-md-12">
                                @include('admin.filters.majorFilter' , ["dropdown"=>true , 'dropdownClass'=>'contentFilter'])
                            </div>
                        </div>
                        <div class = "form-group form-md-line-input form-md-floating-label has-info">
                            <div class = "col-md-12">
                                @include("admin.filters.contentTypeFilter" , ['dropdownClass'=>'contentFilter'])
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                        {{--<div class="col-md-12">--}}
                        {{--<a href="javascript:;" class="btn btn-lg bg-font-dark reload" style="background: #489fff">فیلتر</a>--}}
                        {{--<img class="hidden" id="order-portlet-loading" src="{{Config::get('constants.FILTER_LOADING_GIF')}}"  width="5%">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    {!! Form::close() !!}
                    <div class = "row text-center">
                        <img class = "hidden" id = "content-table-loading" src = "/acm/extra/load2.GIF" alt = "loading" style = "width: 20px;">
                    </div>
                </div>
            </div>
            @if($soonContents->isNotEmpty())
                <div class = "row">
                    <div class = "col-md-12 margin-top-20">
                        @include("content.partials.similarContent" , [
                            "soonContentsWithSameType"=>$soonContents
                        ])

                    </div>
                </div>
            @endif
        </div>
        <div class = "col-md-8">

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class = "portlet box red ">
                <div class = "portlet-title">
                    <div class = "caption">
                        <i class = "fa fa-list-ul" aria-hidden = "true"></i>
                    </div>
                    <div class = "tools"></div>

                </div>
                <div class = "portlet-body">
                    <table class = "table table-striped table-bordered table-hover dt-responsive" id = "content_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class = "all text-center"> نام</th>
                            <th class = "min-tablet text-center"> مقطع</th>
                            <th class = "min-tablet text-center"> رشته</th>
                            <th class = "min-tablet text-center"> نوع محتوا</th>
                            <th class = "all"></th>
                        </tr>
                        </thead>
                        <tbody class = "text-center">
                        {{--Loading By Ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
            <div class = "row">
                @foreach($products as $product)
                    <div class = "col-md-4">
                        <div class = "col-item">
                            <div class = "photo">
                                <img src = "{{ $product->photo }}" class = "img-responsive" alt = "عکس محصول@if(isset($product[0])) {{$product->name}} @endif"/>
                            </div>
                            <div class = "info">
                                <div class = "row">
                                    <div class = "price col-md-12">
                                        <h5 class = "bold text-center">
                                            @if(strlen($product->name)>0 ) {{$product->name}} @endif</h5>
                                        <h5 class = "price-text-color bold">
                                            @if($product->isFree)
                                                <div class = "cbp-l-grid-projects-desc text-center bold m--font-danger product-potfolio-free">
                                                    رایگان
                                                </div>
                                            @elseif($costCollection[$product->id]["cost"] == 0)
                                                <div class = "cbp-l-grid-projects-desc text-center bold m--font-info product-potfolio-no-cost">
                                                    قیمت: پس از انتخاب محصول
                                                </div>
                                            @elseif($costCollection[$product->id]["productDiscount"]+$costCollection[$product->id]["bonDiscount"]>0)
                                                <div class = "cbp-l-grid-projects-desc text-center bold m--font-danger product-potfolio-real-cost">@if(isset($costCollection[$product->id]["cost"])){{number_format($costCollection[$product->id]["cost"])}}
                                                    تومان@endif</div>
                                                <div class = "cbp-l-grid-projects-desc text-center bold font-green product-potfolio-discount-cost"> @if(Auth::check()) {{number_format((1 - ($costCollection[$product->id]["bonDiscount"] / 100)) * ((1 - ($costCollection[$product->id]["productDiscount"] / 100)) * $costCollection[$product->id]["cost"]))}} @else @if(isset($costCollection[$product->id]["cost"])){{number_format(((1-($costCollection[$product->id]["productDiscount"]/100))*$costCollection[$product->id]["cost"]))}}
                                                    تومان@endif @endif</div>
                                            @else
                                                <div class = "cbp-l-grid-projects-desc text-center bold font-green product-potfolio-no-discount">@if(isset($costCollection[$product->id]["cost"])){{number_format($costCollection[$product->id]["cost"])}}
                                                    تومان@endif </div>
                                            @endif
                                        </h5>
                                    </div>
                                    {{--<div class="rating hidden-sm col-md-6">--}}
                                    {{--<i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">--}}
                                    {{--</i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">--}}
                                    {{--</i><i class="fa fa-star"></i>--}}
                                    {{--</div>--}}
                                </div>
                                <div class = "separator clear-left">
                                    <p class = "">
                                        <a href = "{{action("Web\ProductController@show" , $product)}}" class = "btn btn-lg green hidden-sm">
                                            <i class = "fa fa-cart-plus"></i>
                                            سفارش
                                        </a>
                                    </p>
                                </div>
                                <div class = "clearfix"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

@endsection

@section("footerPageLevelPlugin")
    <script src = "{{ mix('/js/footer_Page_Level_Plugin.js') }}" type = "text/javascript"></script>
    <script src = "/assets/global/scripts/datatable.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/datatables/datatables.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/table-datatables-responsive.min.js" type = "text/javascript"></script>
    <script src = "/js/extraJS/jQueryNumberFormat/jquery.number.min.js" type = "text/javascript"></script>
@endsection

@section("extraJS")
    <script src = "{{ mix('/js/Page_Level_Script_all.js') }}" type = "text/javascript"></script>
    <script src = "/js/extraJS/scripts/admin-makeDataTable.js" type = "text/javascript"></script>
    <script type = "text/javascript">

        makeDataTableWithoutButton("content_table");

        $(document).on("change", ".contentFilter", function () {
            contentLoad();
        });

        $(document).on("click", "#goButton", function () {
            contentLoad();
        });

        $(document).ready(function () {
            contentLoad();
        });

        function contentLoad() {
            var formData = $("#contentFilterForm").serialize();
            var columns = ["columns[]=name", "columns[]=show", "columns[]=grade", "columns[]=major", "columns[]=contentType"];
            formData = formData + "&" + columns.join('&');
            $("#content-table-loading").removeClass("hidden");
            $.ajax({
                type: "GET",
                url: "{{action("Web\ContentController@index")}}",
                data: formData,
                success: function (result) {
                    // console.log(result);
                    // console.log(result.responseText);
                    var newDataTable = $("#content_table").DataTable();
                    newDataTable.destroy();
                    $('#content_table > tbody').html(result);
                    makeDataTableWithoutButton("content_table");
                    $("#content-table-loading").addClass("hidden");
                },
                error: function (result) {
//                    console.log(result);
//                    console.log(result.responseText);
                }
            });
            return false;
        }

        function initialContentTypeSelect() {
            var selected = $("#rootContentTypes option:selected").text();
            if (selected == "آزمون") {
                $("#childContentTypes").prop("disabled", false);
            } else {
                $("#childContentTypes").val("0");
                $("#childContentTypes").prop("disabled", true);
            }
        }

        initialContentTypeSelect();

        $('#rootContentTypes').on('change', function () {
            initialContentTypeSelect();
        });
    </script>
    <script type = "text/javascript">
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
