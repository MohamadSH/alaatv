@extends("app")

@section("pageBar")
    {{--<div class="page-bar">--}}
    {{--<ul class="page-breadcrumb">--}}
    {{--<li>--}}
    {{--<i class="icon-home"></i>--}}
    {{--<a href="{{action("IndexPageController")}}">@lang('page.Home')</a>--}}
    {{--<i class="fa fa-angle-left"></i>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
@endsection

@section("content")
    {{--@if($isLive)--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-2"></div>--}}
    {{--<div class="col-md-8">--}}
    {{--<div class="portlet light">--}}
    {{--<div class="portlet-title text-center" >--}}
    {{--@if(\App\Product::where('id',65)->first()->isHappening() === true)--}}
    {{--<h4  style="width: 100%">--}}
    {{--<i class="fa fa-video-camera font-dark"></i>--}}
    {{--<span class="caption-subject font-dark sbold uppercase"> پخش آنلاین {{$product->name}}</span>--}}
    {{--</h4>--}}
    {{--@else--}}
    {{--<h4  style="width: 100%">--}}
    {{--<i class="fa fa-cloud-download font-dark"></i>--}}
    {{--<span class="caption-subject font-dark sbold uppercase"> دانلود {{$product->name}}</span>--}}
    {{--</h4>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--<div class="portlet-body form">--}}
    {{--<iframe src="http://sanatisharif.ir/SanatiSharif-Video/11/26/6203" height="467" width="710" style="border: hidden;" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen oallowfullscreen msallowfullscreen></iframe>--}}
    {{--@if(\App\Product::where('id',65)->first()->isHappening() === true || \App\Product::where('id',85)->first()->isHappening() === true)--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-1"></div>--}}
    {{--<div class="col-md-10">--}}
    {{--<video style="width: 100%" controls  poster="/acm/extra/video-broken.png">--}}
    {{--<source src="" type="video/mp4">--}}
    {{--<span class="bold font-red">مرورگر شما HTML5 را پشتیبانی نمی کند</span>--}}
    {{--</video>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="row">--}}
    {{--<div class=" col-md-12 bold" style="text-align: justify;line-height: 2;">--}}
    {{--<h4 class="bold text-center font-red" style="line-height: 2">ضمن عرض پوزش ، پخش آنلاین همایش به دلیل انتخابات ریاست جمهوری قطع می باشد.</h4>--}}
    {{--<p>شما عزیزان می توانید فردای روز برگزاری همایش ، فیلمهای همایش به همراه جزوات ارائه شده را با مراجعه به همین صفحه دانلود نمایید</p>--}}
    {{--<p style="">همچنین در صورتی که  مایل هستید فیلمها و جزوات را از طریق پست دریافت نمایید ، لازم است ابتدا با مراجعه به پروفایل خود ، قسمت آدرس را تکمیل نموده و سپس درخواست ارسال پستی را از طریق کانال تلگرام و یا تماس تلفنی به ما اعلام نمایید. لازم به ذکر است فیلم ها و جزوات از طریق پست پیشتاز برای شما ارسال خواهند شد و  <span class="font-red-thunderbird" style="font-size: larger">ارسال پستی رایگان بوده و هزینه ای دریافت نخواهد شد.</span></p>--}}
    {{--<p class="text-center"><a href="{{action("UserController@showProfile")}}"  class="btn btn-lg purple" style="font-size: larger">تکمیل آدرس پستی</a></p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@else--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-3"></div>--}}
    {{--<div class="col-md-6">--}}
    {{--<div class="clearfix">--}}
    {{--<h4 class="block bold"><i class="fa fa-video-camera font-dark"></i>     فیلم ها</h4>--}}
    {{--@if($product->id == 65)--}}
    {{--<a  class="btn blue btn-outline  btn-block" href="{{action("HomeController@download" , ["content"=>"فیلم همایش","fileName"=>"partOne" ])}}" ><i class="fa fa-download"></i>قسمت اول</a>--}}
    {{--<a  class="btn blue btn-outline  btn-block" href="#" ><i class="fa fa-download"></i>قسمت دوم</a>--}}
    {{--<a  class="btn blue btn-outline  btn-block" href="#" ><i class="fa fa-download"></i>قسمت سوم</a>--}}
    {{--@elseif($product->id == 85)--}}
    {{--<a  class="btn blue btn-outline  btn-block" href="{{action("HomeController@download" , ["content"=>"فیلم همایش","fileName"=>"partOne" ])}}" ><i class="fa fa-download"></i>قسمت اول</a>--}}
    {{--<a  class="btn blue btn-outline  btn-block" href="#" ><i class="fa fa-download"></i>قسمت دوم</a>--}}
    {{--<a  class="btn blue btn-outline  btn-block" href="#" ><i class="fa fa-download"></i>قسمت سوم</a>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<hr>--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-3"></div>--}}
    {{--<div class="col-md-6">--}}
    {{--<div class="clearfix">--}}
    {{--<h4 class="block bold"><i class="fa fa-book font-dark"></i> جزوات</h4>--}}
    {{--@if(!$product->validProductfiles()->get()->isEmpty() ||--}}
    {{--(!$product->parents->isEmpty() && !$product->parents->first()->validProductfiles()->get()->isEmpty()) )--}}
    {{--<div class="clearfix">--}}

    {{--@foreach($product->validProductfiles()->get() as $productFile)--}}
    {{--@if($productFile->enable)--}}
    {{--<a href="{{action("HomeController@download" , ["content"=>"فایل محصول","fileName"=>$productFile->file ])}}" class="btn red btn-outline  btn-block">--}}
    {{--<i class="fa fa-download"></i> @if(isset($productFile->name) && strlen($productFile->name)>0){{$productFile->name}}@else {{$productFile->file}} @endif </a>--}}
    {{--@endif--}}
    {{--@endforeach--}}
    {{--@if(!$product->parents->isEmpty())--}}
    {{--@foreach($product->parents->first()->validProductfiles()->get() as $productFile)--}}
    {{--@if($productFile->enable)--}}
    {{--<a href="{{action("HomeController@download" , ["content"=>"فایل محصول","fileName"=>$productFile->file ])}}" class="btn red btn-outline  btn-block">--}}
    {{--<i class="fa fa-download"></i> @if(isset($productFile->name) && strlen($productFile->name)>0){{$productFile->name}}@else {{$productFile->file}} @endif </a><br>--}}
    {{--@endif--}}
    {{--@endforeach--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--@else--}}
    {{--<h3 class="font-red bold  text-center">هنوز درج نشده</h3>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@else--}}
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption pull-right">
                        {{--<i class="fa fa-play"></i>--}}
                        <img src="/img/extra/live-rs.png" height="50px">
                        {{--<span class="caption-subject bold uppercase">پخش زنده</span>--}}
                        {{--<span class="caption-helper">weekly stats...</span>--}}
                    </div>
                </div>
                <div class="portlet-body">
                    @if(!$isLive)
                        <iframe src="https://sanatisharif.ir/SanatiSharif-Video/15/30/7145"
                                style="border: hidden; width: 100% ;height:467px" frameborder="0" allowfullscreen
                                webkitallowfullscreen mozallowfullscreen oallowfullscreen msallowfullscreen></iframe>
                    @else
                        <h2 class="block bold text-center font-blue" style="line-height:normal">پخش آنلاین چهارشنبه
                            (96/12/2) ساعت 22:00 آغاز خواهد شد</h2>
                    @endif
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
    {{--@endif--}}
@endsection

