@extends("app",["pageName"=>"siteMap"])

@section("css")
    <link rel = "stylesheet" href = "{{ mix('/css/all.css') }}">
@endsection

@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{route('web.index')}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>نقشه سایت</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-6">
            <div class = "portlet light ">
                <div class = "portlet-title">
                    <div class = "caption">
                        <i class = "fa fa-sitemap" aria-hidden = "true"></i>
                        <span class = "caption-subject font-blue-sharp bold uppercase">وب سایت آلاء در یک نگاه</span>
                    </div>
                    {{--<div class="actions">--}}
                    {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
                    {{--<i class="icon-cloud-upload"></i>--}}
                    {{--</a>--}}
                    {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
                    {{--<i class="icon-wrench"></i>--}}
                    {{--</a>--}}
                    {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
                    {{--<i class="icon-trash"></i>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                </div>
                <div class = "portlet-body">
                    <div id = "tree_1" class = "tree-demo">
                        <ul>
                            <li> صفحه اصلی
                                <ul>
                                    <li data-jstree = '{ "opened" : true,"selected" : true }'> خدمات
                                        <ul>
                                            @foreach($products as $product)
                                                <li data-jstree = '{ "type" : "file","disabled" : true }'>
                                                    <a href = "{{ action("Web\ProductController@show",$product) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li data-jstree = '{ "icon" : "fa fa-warning icon-state-danger" }'>
                                        <a href = "/">استعلام تکنسین های آلاء</a>
                                    </li>
                                </ul>
                            </li>
                            <li data-jstree = '{ "opened" : true }'> مقالات
                                <ul>
                                    @foreach($articlecategories as $ac)
                                        <li data-jstree = '{ "opened" : true }'> {{ $ac->name }}
                                            <ul>
                                                @foreach($ac->articles as $article)
                                                    <li data-jstree = '{ "type" : "file","disabled" : true }'>
                                                        <a href = "{{ action("Web\ArticleController@show",$article) }}">
                                                            {{ $article->title }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                    @foreach($articlesWithoutCategory as $article)
                                        <li data-jstree = '{ "type" : "file","disabled" : true }'>
                                            <a href = "{{ action("Web\ArticleController@show",$article) }}">
                                                {{ $article->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li data-jstree = '{ "type" : "file","disabled" : false }'>
                                <a href = "{{ action("Web\ContactUsController") }}">
                                    @lang('page.contact us')
                                </a>
                            </li>
                            <li data-jstree = '{ "type" : "file","disabled" : false }'>
                                <a href = "{{ action("Web\HomeController@certificates") }}">
                                    مجوزها
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class = "col-md-6">
            <div class = "portlet light ">
                <div class = "portlet-title">
                    <div class = "caption">
                        <i class = "icon-social-dribbble font-blue-sharp"></i>
                        <span class = "caption-subject font-blue-sharp bold uppercase">ثبت سفارش در آلاء</span>
                    </div>
                    {{--<div class="actions">--}}
                    {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
                    {{--<i class="icon-cloud-upload"></i>--}}
                    {{--</a>--}}
                    {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
                    {{--<i class="icon-wrench"></i>--}}
                    {{--</a>--}}
                    {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
                    {{--<i class="icon-trash"></i>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                </div>
                <div class = "portlet-body">
                    <p>
                        ابتدا از صفحه اصلی وب سایت یکی از خدمات را انتخاب نمایید
                    </p>
                    <p>
                        بدین ترتیب شما وارد صفحه ی نمایش خدمت آلاء می شوید که در این صفحه می توانید جزئیات خدمت مورد نظر خود را تعیین بفرمایید
                    </p>
                    <p>
                        سپس بر روی سفارش کلیک بفرمایید، بعد از وارد نمودن اطلاعات خود به صفحه ی بازبینی سفارش وارد می شوید
                    </p>
                    <p>
                        در اینجا بار دیگر می توانید سفارش خود را بررسی بفرمایید که در صورت لزوم آن را اصلاح کنید.
                    </p>
                    <p>
                        در مرحله بعد وارد صفحه ای می شوید که می توانید نوع پرداخت را تعیین بفرمایید و در صورت انتخاب پرداخت آنلاین می توانید درگاه بانک مورد نظر خود را انتخاب بفرمایید
                    </p>
                    <p>
                        همچنین در این قسمت در صورت داشتن کد تخفیف tecs می توانید آن را وارد نمایید تا از تخفیف های دوره ای و مناسبتی آلاء برخوردار شوید
                    </p>
                    <p>
                        در نهایت بر روی ثبت سفارش کلیک نمایید تا کارشناسان آلاء کار شما را با نهایت سرعت و دقت پی گیری نمایند.
                    </p>
                </div>
            </div>
        </div>

    </div>
@endsection

@section("extraJS")
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src = "/assets/global/plugins/jstree/dist/jstree.min.js" type = "text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src = "/assets/global/scripts/app.min.js" type = "text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src = "/assets/pages/scripts/ui-tree.min.js" type = "text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endsection
