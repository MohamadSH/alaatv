@extends("app" , ["pageName"=>$pageName])

@section('right-aside')
@endsection
@section("content")
    @include("partials.slideShow1" ,["marginBottom"=>"25"])
    
    <div class="m--clearfix"></div>
    <!--begin:: Widgets/Stats-->
    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 m--bg-warning">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.konkoor1').offset().top - 100},'slow');" href="#konkoor1">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <h2 class="m-widget24__title">
                                    کنکور نظام قدیم
                                </h2>
                                <br>
                                <span class="m-widget24__desc m--font-light">
				            آلاء
				            </span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
                <div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 m--bg-accent">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.konkoor2').offset().top - 100},'slow');" href="#konkoor2">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <h2 class="m-widget24__title">
                                    کنکور نظام جدید
                                </h2>
                                <br>
                                <span class="m-widget24__desc m--font-light">
				            آلاء
				            </span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
                <div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 m--bg-success">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.yazdahom').offset().top - 100},'slow');" href="#yazdahom">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <h2 class="m-widget24__title">
                                    پایه یازدهم
                                </h2>
                                <br>
                                <span class="m-widget24__desc m--font-light">
				            آلاء
				            </span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
                <div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 m--bg-fill-info">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('.dahom').offset().top - 100},'slow');" href="#dahom">
                        <!--begin::Total Profit-->
                        <div class="m-widget24 m--align-center">
                            <div class="m-widget24__item">
                                <h2 class="m-widget24__title">
                                    پایه دهم
                                </h2>
                                <br>
                                <span class="m-widget24__desc m--font-light">
				            آلاء
				            </span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--end:: Widgets/Stats-->
    @foreach($sections as $section)
        @if($section['lessons']->count() > 0)
            <div class="row {{$section["class"]}}">
                <div class="col-12">
                    <div class="a--devider-with-title">
                        <div class="a--devider-title">
                            <a href="{{ urldecode(action("Web\ContentController@index" , ["tags" => $section["tags"]])) }}" class="m-link m-link--primary">
                                {{$section["descriptiveName"]}}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="a--owl-carousel-type-1 owl-carousel owl-theme">
                        @foreach($section["lessons"] as $lesson)
                            @include('partials.widgets.set1',[
                            'widgetActionName' => $section["descriptiveName"].'/ نمایش همه',
                            'widgetActionLink' => $section["url"],
                            'widgetTitle'      => $lesson["displayName"],
                            'widgetPic'        => (isset($lesson["pic"]) && strlen($lesson["pic"])>0 ?  $lesson["pic"]."?w=253&h=142" : 'https://via.placeholder.com/235x142'),
                            'widgetAuthor' => $lesson["author"],
                            'widgetLink'       => (isset($lesson["content_id"]) && $lesson["content_id"]>0 ? action("Web\ContentController@show", $lesson["content_id"]):""),
                            'widgetCount' => $lesson["content_count"],
                            'widgetScroll' => 1
                            ])
                        @endforeach
                    </div>
                </div>
            </div>

            @foreach($section["ads"] as $image => $link)
                @include('partials.bannerAds', ['img'=>$image , 'link'=>$link])
            @endforeach
        @endif
    @endforeach
    
    @include("partials.certificates")
@endsection


@section('page-js')
    <script src="{{ mix('/js/page-homePage.js') }}"></script>
@endsection