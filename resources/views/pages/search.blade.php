@extends("app",["pageName"=>"search"])

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>جستجو</span>
            </li>
        </ul>
    </div>
@endsection
@section("content")
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-globe font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">جستجو در نخنه خاک</span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" class="active" data-toggle="tab">خدمات</a>
                        </li>
                        <li>
                            <a href="#tab_1_2" data-toggle="tab"> مقالات </a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <!--BEGIN TABS-->
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            @if($productSearch->total() === 0)
                                <p>خدمتی یافت نشد!</p>
                            @else
                                <ul class="feeds">
                                    @foreach($productSearch as $p)
                                        @if(!$p->hasParents())
                                            <li>
                                                <a href="{{ action("ProductController@show",$p) }}">
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-sm label-info">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc">{{ $p->name }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date"> {{ $p->CreatedAt_Jalali() }}</div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>

                            @endif

                        </div>
                        <div class="tab-pane" id="tab_1_2">

                            @if($articleSearch->total() === 0)
                                <p>مقاله ای یافت نشد!</p>
                            @else
                                <ul class="feeds">
                                    @foreach($articleSearch as $art)
                                        <li>
                                            <a href="{{ action('ArticleController@show',$art) }}">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-book"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"> {{ $art->title }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"> {{ $art->CreatedAt_Jalali() }}</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <!--END TABS-->
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>

@endsection