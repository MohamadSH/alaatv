@extends("app")

@section("pageBar")

@endsection

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("metadata")
    @parent
    <meta name="_token" content="{{ csrf_token() }}">
@endsection


@section("content")
    <div class="hidden">
        @include("systemMessage.flash")
    </div>
    <div class="row" >
        <div class="col-md-12">
            <div class="portlet light bordered" >
                <div class="portlet-body" >
                    <div class="row" >
                        @include("partials.checkoutSteps" , ["step"=>2])
                        @if( $orderproducts->isEmpty() )
                            <div class="row static-info">
                                <div class="col-md-12 " style="text-align: center">
                                    <h3 class="bold font-yellow-gold">موردی انتخاب نشده است!</h3>
                                </div>
                            </div>
                            <div class="row static-info margin-top-40" style="text-align: center;">
                                <a href="{{action("ProductController@search")}}"   class="btn yellow btn-outline">اردوها و همایش ها</a>
                            </div>
                        @else
                        <div class="col-md-12" id="printBill-div"  style="direction: rtl">
                            <div  class="portlet @if($orderproducts->isEmpty() ) yellow-gold @else dark @endif  box">
                                <div class="portlet-title">
                                    <div class="caption">
                                        فاکتور سفارش
                                            @if(session()->has("adminOrder_id"))
                                            برای {{Session::get("customer_firstName")}} {{Session::get("customer_lastName")}}
                                                {{--@else--}}
                                            {{--{{ Auth::user()->firstName.Auth::user()->lastName }}--}}
                                            @endif

                                         </div>
                                </div>
                                <div class="portlet-body" >

                                    {{--@if( $orderproducts->isEmpty() )--}}
                                            {{--<div class="row static-info">--}}
                                                {{--<div class="col-md-12 " style="text-align: center">--}}
                                                    {{--<h3 class="bold">موردی انتخاب نشده است!</h3>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="row static-info margin-top-40" style="text-align: center;">--}}
                                                {{--<a href="{{action("ProductController@search")}}"   class="btn yellow-casablanca btn-outline">اردوها و همایش ها</a>--}}
                                            {{--</div>--}}
                                    {{--@else--}}
                                        <div class="clearfix" style="height: 15px;"></div>
                                        @foreach($orderproducts as $orderproduct)
                                                <div class="row " >
                                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 no-print">
                                                            @if($orderproductLinks->has($orderproduct->id))
                                                                <a target="_blank" href="{{$orderproductLinks[$orderproduct->id]}}"><img src="{{ route('image', ['category'=>'4','w'=>'148' , 'h'=>'148' ,  'filename' =>  $orderproduct->product->getRootImage() ]) }}" alt="عکس محصول" width="100%"></a>
                                                            @else
                                                                <img src="{{ route('image', ['category'=>'4','w'=>'148' , 'h'=>'148' ,  'filename' =>  $orderproduct->product->getRootImage() ]) }}" alt="عکس محصول" width="100%">
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                                                            <div class="row static-info">
                                                                <div class="col-md-4 name" style="font-style: italic"> نام </div>
                                                                <div class="col-md-8 value">
{{--                                                                        @if($orderproduct->product->hasParents()){{$orderproduct->product->parents->first()->name}}--}}
{{--                                                                        @else {{$orderproduct->product->name}}--}}
                                                                        {{--@endif--}}
                                                                    {{$orderproduct->product->getDisplayName()}}
                                                                </div>
                                                            </div>
                                                            @if($orderproduct->product->getGrandParent() && $orderproduct->product->getGrandParent()->producttype_id == Config::get("constants.PRODUCT_TYPE_SELECTABLE"))
                                                                @if($orderproduct->product->attributevalueTree('main')->isNotEmpty())
                                                                    <div class="row static-info">
                                                                        <div class="col-md-4 name" style="font-style: italic"> ویژگی ها </div>
                                                                        <div class="col-md-8 value">
                                                                            @foreach($orderproduct->product->attributevalueTree('main') as $attributevalue)
                                                                                {{$attributevalue["attribute"]->displayName}} : <span style="font-weight: normal">{{$attributevalue["attributevalue"]->name}} @if(isset(   $attributevalue["attributevalue"]->pivot->description) && strlen($attributevalue["attributevalue"]->pivot->description)>0 ) {{$attributevalue["attributevalue"]->pivot->description}} @endif</span></br>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                @if($orderproduct->product->attributevalues('main')->get()->isNotEmpty())
                                                                    <div class="row static-info">
                                                                        <div class="col-md-4 name" style="font-style: italic"> ویژگی ها </div>
                                                                        <div class="col-md-8 value">
                                                                            @foreach($orderproduct->product->attributevalues('main')->get() as $attributevalue)
                                                                                {{$attributevalue->attribute->displayName}} : <span style="font-weight: normal">{{$attributevalue->name}} @if(isset(   $attributevalue->pivot->description) && strlen($attributevalue->pivot->description)>0 ) {{$attributevalue->pivot->description}} @endif</span></br>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            <hr>
                                                             @if($orderproduct->product->isFree ||  ($orderproduct->product->hasParents() && $orderproduct->product->parents->first()->isFree) )
                                                                <div class="row static-info">
                                                                    <div class="col-md-4 name" style="font-style: italic"> قیمت محصول </div>
                                                                    <div class="col-md-8 value font-red">  رایگان </div>
                                                                </div>
                                                                {{--<div class="row static-info margin-top-40 no-print" style="text-align: center;">--}}
                                                                    {{--<a href="{{action("OrderController@verifyPayment")}}"   class="btn green btn-outline">تکمیل سفارش<i class="fa fa-arrow-left" aria-hidden="true"></i></a>--}}
                                                                {{--</div>--}}
                                                             @else
                                                                @if($costCollection[$orderproduct->id]["cost"] == 0)
                                                                    <div class="row static-info">
                                                                        <div class="col-md-4 name" style="font-style: italic"> قیمت محصول </div>
                                                                        <div class="col-md-8 value">{{number_format($costCollection[$orderproduct->id]["cost"])}} تومان</div>
                                                                        @if($costCollection[$orderproduct->id]["extraCost"]>0)
                                                                            <div class="col-md-4 name" style="font-style: italic"> قیمت برای شما </div>
                                                                            <div class="col-md-8 value"> {{number_format($costCollection[$orderproduct->id]["cost"]+$costCollection[$orderproduct->id]["extraCost"])}} تومان</div>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="row static-info">
                                                                        <div class="col-md-4 name" style="font-style: italic"> قیمت محصول </div>
                                                                            <div class="col-md-8 value"> {{number_format($costCollection[$orderproduct->id]["cost"])}} تومان</div>
                                                                                @if($orderproduct->isGiftType())
                                                                                    <div class="col-md-4 name font-red bold" style="font-style: italic"> تخفیف </div>
                                                                                    <div class="col-md-8 value font-red bold"> {{number_format($costCollection[$orderproduct->id]["cost"])}} تومان</div>
                                                                                @else
                                                                                    @if($costCollection[$orderproduct->id]["productDiscount"] > 0 || $costCollection[$orderproduct->id]["productDiscountAmount"]>0)
                                                                                        <div class="col-md-4 name font-red bold" style="font-style: italic"> تخفیف محصول </div>
                                                                                        <div class="col-md-8 value font-red bold"> {{number_format((($costCollection[$orderproduct->id]["productDiscount"]/100)*$costCollection[$orderproduct->id]["cost"]) + $costCollection[$orderproduct->id]["productDiscountAmount"])}} تومان</div>
                                                                                    @endif
                                                                                    @if($costCollection[$orderproduct->id]["bonDiscount"]>0)
                                                                                        <div class="col-md-4 name font-red-intense bold" style="font-style: italic"> تخفیف بن </div>

                                                                                        <div class="col-md-8 value font-red-intense"> {{number_format(($costCollection[$orderproduct->id]["bonDiscount"]/100) * ( ( (1-($costCollection[$orderproduct->id]["productDiscount"]/100))*$costCollection[$orderproduct->id]["cost"]) - $costCollection[$orderproduct->id]["productDiscountAmount"])) }} تومان ({{$orderproduct->userbons->sum("pivot.usageNumber")}} بن)</div>
                                                                                    @endif
                                                                                    @if($orderproduct->attributevalues->isNotEmpty())
                                                                                            <div class="col-md-4 name" style="font-style: italic"> ویژگی های افزوده </div>
                                                                                            <div class="col-md-8 value">
                                                                                                @foreach($orderproduct->attributevalues as $extraAttributevalue)
                                                                                                    {{$extraAttributevalue->attribute->displayName}} :<span style="font-weight: normal">{{$extraAttributevalue->name}} @if(isset($extraAttributevalue->pivot->extraCost) && $extraAttributevalue->pivot->extraCost>0)(+ {{number_format($extraAttributevalue->pivot->extraCost)}} تومان)@endif</span></br>
                                                                                                @endforeach
                                                                                            </div>
                                                                                    @endif
                                                                                @endif
                                                                    </div>
                                                                <hr>
                                                                    <div class="row static-info">
                                                                        <div class="col-md-4 name font-blue-steel bold" style="font-style: italic"> قیمت برای شما </div>
                                                                        <div class="col-md-8 value font-blue-steel"> {{number_format((int)((1-($costCollection[$orderproduct->id]["bonDiscount"]/100)) * ( ( (1-($costCollection[$orderproduct->id]["productDiscount"]/100))*$costCollection[$orderproduct->id]["cost"]) - $costCollection[$orderproduct->id]["productDiscountAmount"]))+$costCollection[$orderproduct->id]["extraCost"])}} تومان</div>
                                                                    </div>
                                                                @endif
                                                             @endif
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <div class="row static-info no-print" style="text-align: center;">
                                                                @if($orderproduct->orderproducttype_id == Config::get("constants.ORDER_PRODUCT_GIFT"))
                                                                    <img src="/assets/extra/gift-box.png">
                                                                @elseif(($orderproduct->product_id != Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_DEFAULT")) || ($orderproduct->product_id == Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_DEFAULT") && !$orderHasOrdrooGheireHozoori))
                                                                    <button  class="btn red btn-outline btn-circle btn-lg removeOrderproduct" data-action="{{action("OrderproductController@destroy",$orderproduct->id)}}"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                </div>
                                                @if(!$orderproduct->product->isFree)
                                                    @if(isset($costCollection[$orderproduct->id]["bonDiscount"]) &&
                                                              $costCollection[$orderproduct->id]["bonDiscount"]==0 &&
                                                              Auth::user()->userHasBon(Config::get("constants.BON1")) &&
                                                              !$orderproduct->product->bons->where("name" , Config::get("constants.BON1"))->where("pivot.discount",">","0")->where("isEnable" , 1)->isEmpty())
                                                        <div  class="custom-alerts alert alert-warning fade in margin-top-40 no-print">
                                                            <i class="fa fa-exclamation-circle"></i>  توجه
                                                            </br>
                                                            <span>{{Auth::user()->userHasBon(Config::get("constants.BON1"))}} عدد {{$bonName}} شما لحاظ نشده است. اگر مایل هستید از آنها استفاده نمایید، باید سفارش را حذف نموده و مجددا اقدام به سفارش نمایید.</span>
                                                        </div>
                                                    @endif
                                                @endif
                                            <hr style=" border: none;height: 1px;/* Set the hr color */color: #333; /* old IE */background-color: #333; /* Modern Browsers */">
                                        @endforeach
                                            <div class="row static-info margin-top-40" style="text-align: center;">
                                                <div class="col-md-12">
                                                    <div class="well">
                                                        <div class="row static-info align-reverse">
                                                            <div class="col-md-12 name  bold" style="text-align: center" > جمع کل :  {{number_format($orderproductsRawCost)}}</div>
                                                            {{--<div class="col-md-5 col-lg-5 col-sm-5 col-xs-5 value" style="text-align: right"> {{number_format($orderproductsRawCost)}} </div>--}}
                                                        </div>
                                                        <div class="row static-info align-reverse">
                                                            <div class="col-md-12 name font-blue bold" style="text-align: center"> قابل پرداخت :      {{number_format($orderCost)}}</div>
                                                            {{--<div class="col-md-5 col-lg-5 col-sm-5 col-xs-5 value font-blue" style="text-align: right"> </div>--}}
                                                        </div>
                                                        <div class="row static-info align-reverse no-print">
                                                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12" >
                                                                <button class="btn dark btn-outline" id="printBill" style="width: 150px"><i class="fa fa-print" aria-hidden="true"></i>پرینت </button>
                                                            </div>
                                                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                                                                <a href="{{action("ProductController@search")}}"   class="btn blue-madison btn-outline" style="width: 150px"><i class="fa fa-plus" aria-hidden="true"></i> افزودن محصول</a>
                                                            </div>
                                                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                                                                <a href="{{action("OrderController@checkoutPayment")}}"   class="btn green btn-outline" style="width: 150px">انتخاب روش پرداخت<i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    {{--@endif--}}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <br/>
                    <br/>
                    <br/>

                </div>
            </div>
        </div>
    </div>
@endsection

@section("extraJS")
    <script type="text/javascript" src="/js/extraJS/jQuery.print.js"></script>
    <script type="text/javascript">
        /**
         * Set token for ajax request
         */
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });
        $(document).on("click", "#printBill", function () {
//                $("#printBill-loading").show(0).delay(2000).hide(0);
            $("#printBill-div").print({
                timeout: 500,
                title: "{{$wSetting->site->name}}",
                noPrintSelector:".no-print",
//                    stylesheet:"/assets/global/css/components-md-rtl.min.css"
            });
        });
        $(document).on("click", ".removeOrderproduct", function (){
            $.ajax({
                type: "DELETE",
                url: $(this).data("action"),
                {{--data: {_token: "{{ csrf_token() }}" },--}}
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        // console.log(response);
                       location.reload();
                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    //The status for when the user is not authorized for making the request
                    401: function (response) {
                        window.location.replace("/403");
                    },
                    //Method Not Allowed
                    405: function (response) {
//                        console.log(response);
//                        console.log(response.responseText);
                        location.reload();
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        // console.log(response);
                    },
                    //The status for when there is error php code
                    500: function (response) {
                        // console.log(response.responseText);
//                            toastr["error"]("خطای برنامه!", "پیام سیستم");
                    },
                    //The status for when there is error php code
                    503: function (response) {
                            toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                    }
                }
            });
        });
    </script>
@endsection