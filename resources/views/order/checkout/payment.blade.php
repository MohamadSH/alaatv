@extends("app")

@section("title")
    <title>آلاء|پرداخت</title>
@endsection

@section("metadata")
    @parent
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section("pageBar")

@endsection

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered ">
                <div class="portlet-body">
                    <div class="row">
                        @include("partials.checkoutSteps" , ["step"=>3])
                        <div class="col-md-12">
                            <div class="portlet dark box">
                                <div class="portlet-title">
                                    <div class="caption">
                                        @if(session()->has("adminOrder_id"))
                                            ثبت نهایی سفارش
                                            برای {{Session::get("customer_firstName")}} {{Session::get("customer_lastName")}}
                                        @else
                                            پرداخت
                                        @endif
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    {{--<div class="row static-info margin-top-20">--}}
                                    @include("systemMessage.flash")
                                    {{--</div>--}}

                                    <div class="row margin-top-10">
                                        @if(!isset($coupon))
                                            <div class="col-lg-3 col-md-3 col-sd-3 col-xs-12 text-center">
                                                <input type="checkbox" class="make-switch"
                                                       data-on-text="&nbsp;کد&nbsp;تخفیف&nbsp;دارم&nbsp;"
                                                       data-off-text="&nbsp;کد&nbsp;تخفیف&nbsp;ندارم&nbsp;"
                                                       id="couponSwitch">
                                            </div>
                                        @endif
                                        <div class="col-lg-9 col-md-9 col-sd-9 col-xs-12"
                                             @if(!isset($coupon)) style="display: none" id="couponForm" @endif>
                                            {!! Form::open(['method' => 'POST','action' => ['OrderController@submitCoupon'] , 'class'=>'form-horizontal' ]) !!}
                                            <div class="form-group">
                                                <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"
                                                       for="gateway" style="text-align: right">کد تخفیف </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-group">
                                                        @if(isset($coupon))
                                                            {!! Form::text('coupon',$coupon->code,['class' => 'form-control' , ]) !!}
                                                        @else
                                                            {!! Form::text('coupon',null,['class' => 'form-control' ]) !!}
                                                        @endif
                                                        <span class="input-group-btn">
                                                                        @if(isset($coupon))
                                                                <a href="{{action("OrderController@removeCoupon")}}"
                                                                   class="btn red">حذف کد تخفیف</a>
                                                            @else
                                                                {!! Form::submit('ثبت کد تخفیف',['class' => 'btn blue']) !!}
                                                            @endif
                                                                        </span>
                                                    </div>
                                                </div>
                                                @if(isset($coupon))
                                                    <div class="col-lg-12">
                                                                        <span class="help-block small bold font-green">
                                                                            @if($coupon->discounttype->id == Config::get("constants.DISCOUNT_TYPE_COST"))
                                                                                کپن تخفیف  {{$coupon->name}}
                                                                                با {{number_format($coupon->discount)}}
                                                                                تومان تخفیف برای سفارش شما ثبت شد.
                                                                            @else
                                                                                کپن تخفیف {{$coupon->name}}
                                                                                با {{$coupon->discount}}% تخفیف برای
                                                                                سفارش شما ثبت شده است.
                                                                            @endif
                                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="col-lg-12">
                                                        <span class="help-block font-blue small bold">پس از وارد کردن کد و زدن دکمه ثبت میزان تخفیف در مبلغ قابل پرداخت اعمال خواهد شد</span>
                                                    </div>
                                                @endif
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            {!! Form::open(['method' => 'POST','action' => ['OrderController@addOrderproduct' , 180] , 'class'=>'form-horizontal' , 'id'=>'donateForm' ]) !!}
                                            <label for="donateSwitch">5 هزار تومان مشارکت می کنم در هزینه های
                                                آلاء</label>
                                            <input type="hidden" name="mode" value="normal">
                                            <input type="checkbox"
                                                   @if(isset($orderHasDonate) && $orderHasDonate) checked
                                                   @endif  id="donateSwitch" value="" class="make-switch"
                                                   data-off-color="danger" data-on-color="success"
                                                   data-off-text="&nbsp;کمک&nbsp;نمی&nbsp;کنم&nbsp;"
                                                   data-on-text="&nbsp;کمک&nbsp;می&nbsp;کنم&nbsp;">
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                    <hr>
                                    @if(session()->has("adminOrder_id") )
                                        <div class="row">
                                            {!! Form::open(['method' => 'GET','action' => ['OrderController@verifyPayment'] , 'id'=>'paymentForm' , 'class'=>'form-horizontal' ]) !!}
                                            <div class="form-group">
                                                <div class="col-lg-12" style="text-align: center;">
                                                    <span class="label bg-green-soft" style="font-size: 15px">مبلغ قابل پرداخت: {{number_format($cost)}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12" style="text-align: center;">
                                                    <a href="{{action("OrderController@checkoutReview")}}"
                                                       class="btn dark btn-outline"><i class="fa fa-chevron-right"
                                                                                       aria-hidden="true"></i>بازبینی</a>
                                                    <button type="submit" class="btn green btn-outline">ثبت نهایی
                                                    </button>
                                                </div>
                                                {!! Form::hidden('paymentmethod','inPersonPayment') !!}
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    @elseif(!isset($invoiceInfo["totalCost"]) || $invoiceInfo["totalCost"] == 0)
                                        <div class="row">
                                            {!! Form::open(['method' => 'GET','action' => ['OrderController@verifyPayment'] , 'id'=>'paymentForm' , 'class'=>'form-horizontal' ]) !!}
                                            <div class="col-md-12 margin-top-20">
                                                {!! Form::textarea('customerDescription',null,['class' => 'form-control' , 'placeholder'=>'اگر توضیحی درباره سفارش خود دارید لطفا اینجا بنویسید' , 'rows'=>'3']) !!}
                                            </div>
                                            <div class="col-md-12 margin-top-40" style="text-align: center;">
                                                <span class="label bg-green-soft" style="font-size: 15px">مبلغ قابل پرداخت: {{number_format($invoiceInfo["totalCost"])}}</span>
                                            </div>
                                            <div class="col-md-12 margin-top-20" style="text-align: center;">
                                                <a href="{{action("OrderController@checkoutReview")}}"
                                                   class="btn dark btn-outline" style="width: 100px"><i
                                                            class="fa fa-chevron-right"
                                                            aria-hidden="true"></i>بازبینی</a>
                                                <button type="submit" class="btn green btn-outline"
                                                        style="width: 100px">ثبت نهایی
                                                </button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    @else
                                        <div class="row">
                                            {!! Form::open(['method' => 'POST','action' => ['TransactionController@create'] , 'id'=>'paymentForm' , 'class'=>'form-horizontal' ]) !!}
                                            <div class="form-group text-center">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                                    <label class="col-lg-5 col-md-5 col-sd-5 col-xs-5 text-center control-label"
                                                           style="text-align: center" for="gateway">روش پرداخت </label>
                                                    <div class="col-lg-7 col-md-7 col-sd-7 col-xs-7">
                                                        {{--{!! Form::select('paymentmethod',["onlinePayment" => "آنلاین"],null,['class' => 'form-control' , 'id'=>'paymentMethod']) !!}--}}
                                                        <text class="form-control-static bold"> آنلاین </text>
                                                        {!! Form::hidden('paymentmethod', 'onlinePayment' , ['id'=>'paymentMethod']) !!}
                                                    </div>

                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " id="gatewayDiv">
                                                    <label class="col-lg-5 col-md-5 col-sd-5 col-xs-5 control-label"
                                                           style="text-align: center" for="gateway">انتخاب
                                                        درگاه </label>
                                                    <div class="col-lg-7 col-md-7 col-sd-7 col-xs-7">
                                                        {!! Form::select('gateway',$gateways,null,['class' => 'form-control' , 'id'=>'gatewaySelect' ]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-3 col-md-3">
                                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left control-label bold font-blue-sharp"
                                                           style="text-align: center ; font-size: medium">
                                                        کیف پول شما: {{number_format($credit)}} تومان
                                                    </label>
                                                    @if($credit > 0 )
                                                        {!! Form::hidden('payByWallet',1 ) !!}
                                                    @endif
                                                    @if(isset($coupon))
                                                        <div class="col-lg-12 col-md-12 margin-top-20 text-left">
                                                            <span class="bold font-blue-sharp"
                                                                  style="font-size: 15px; padding: 0px 5px 0px 5px;">
                                                                {{($credit>0)?"جمع کل:":"مبلغ قابل پرداخت:"}}
                                                                <lable id="totalCost"
                                                                       style="text-decoration: line-through;">
                                                                    {{number_format($invoiceInfo["totalCost"])}}
                                                                </lable>
                                                            تومان
                                                            </span>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 margin-top-20 text-left">
                                                            <span class="bold font-red"
                                                                  style="padding: 0px 5px 0px 5px; font-size: 15px">
                                                                    برای شما {{number_format($invoiceInfo["totalCost"])}} تومان
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class="col-lg-12 col-md-12 margin-top-20 text-left">
                                                            <span class="bold font-blue-sharp" style="font-size: 15px">
                                                                {{($credit>0)?"جمع کل:":"مبلغ قابل پرداخت:"}}
                                                                <lable id="totalCost">
                                                                    {{number_format($invoiceInfo["totalCost"])}}
                                                                </lable>
                                                            تومان
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if($credit > 0)
                                                        <div class="col-lg-12 col-md-12 margin-top-20 text-left">
                                                        <span class="bold font-blue-sharp" style="font-size: 15px">
                                                            استفاده از کیف پول:
                                                                    <lable id="totalCost">
                                                                        {{number_format($invoiceInfo["paidByWallet"])}}
                                                                    </lable>
                                                                    تومان
                                                        </span>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 margin-top-20 text-left">
                                                            <span class="bold font-blue-sharp" style="font-size: 15px">مبلغ قابل پرداخت:
                                                                        <lable id="totalCost">
                                                                            {{number_format( $invoiceInfo["payableCost"])}}
                                                                        </lable>
                                                                        تومان
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-lg-9 col-md-9" style="    padding: 0px 30px 0px 30px;">
                                                    {!! Form::textarea('customerDescription',null,['class' => 'form-control' , 'placeholder'=>'اگر توضیحی درباره سفارش خود دارید اینجا بنویسید' , 'rows'=>'3']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12 col-md-12 margin-top-10 text-center">
                                                    <a href="{{action("OrderController@checkoutReview")}}"
                                                       class="btn dark btn-outline" style="width: 100px">
                                                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                                        بازبینی
                                                    </a>
                                                    <button type="submit" class="btn green btn-outline"
                                                            style="width: 100px">
                                                        {{($invoiceInfo["payableCost"] == 0)?"ثبت نهایی":"پرداخت"}}
                                                    </button>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
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
    <script src="/js/extraJS/jQueryNumberFormat/jquery.number.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        /**
         * Set token for ajax request
         */
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                }
            });
        });

        function setPaymentController() {
            if ($("#paymentMethod").val() == "onlinePayment") {
                $("#paymentForm").attr("action", "{{action('TransactionController@paymentRedirect')}}");
                $("#gatewaySelect").prop('disabled', false);
                $("#gatewayDiv").show();
            } else if ($("#paymentMethod").val() == "inPersonPayment" || $("#paymentMethod").val() == "offlinePayment") {
                $("#paymentForm").attr("action", "{{action('OrderController@verifyPayment')}}");
                $("#gatewaySelect").prop('disabled', true);
                $("#gatewayDiv").hide();
            }
        }

        $(document).ready(function () {
            setPaymentController();
        });

        $(document).on("change", "#paymentMethod", function () {
            setPaymentController();
        });

        $(document).on("switchChange.bootstrapSwitch", "#couponSwitch", function () {
            if ($(this).is(':checked')) {
                $("#couponForm").fadeIn();
            } else {
                $("#couponForm").fadeOut(1000);
            }
        });

        var submitDonateAjax;
        var cancelDonateAjax;
        $(document).on("switchChange.bootstrapSwitch", "#donateSwitch", function () {
            if ($(this).is(':checked')) {
                var formData = $("#donateForm").serialize();
                if (submitDonateAjax) {
                    submitDonateAjax.abort();
                }
                submitDonateAjax = $.ajax({
                    type: "POST",
                    url: $("#donateForm").attr("action"),
                    data: formData,
                    // contentType: "application/json",
                    // dataType: "json",
                    statusCode: {
                        200: function (response) {
                            location.reload();
                            // $("#totalCost").text(response.cost).number(true) ;
                        },
                        //The status for when the user is not authorized for making the request
                        401: function (ressponse) {
                            location.reload();
                        },
                        403: function (response) {
                            window.location.replace("/403");
                        },
                        404: function (response) {
                            window.location.replace("/404");
                        },
                        //The status for when form data is not valid
                        422: function (response) {
                            //
                        },
                        //The status for when there is error php code
                        500: function (response) {
                            // console.log(response.responseText);
                            // toastr["error"]("خطای برنامه!", "پیام سیستم");
                        },
                        //The status for when there is error php code
                        503: function (response) {
                            console.log(response);
                            console.log(response.responseText);
                            // toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                        }
                    }
                });

                return false;
            } else {
                if (cancelDonateAjax) {
                    cancelDonateAjax.abort();
                }
                cancelDonateAjax = $.ajax({
                    type: "DELETE",
                    url: "{{action("OrderController@removeOrderproduct" , 180)}}",
                    contentType: "application/json",
                    dataType: "json",
                    statusCode: {
                        200: function (response) {
                            location.reload();
                            // $("#totalCost").text(response.cost).number(true) ;
                        },
                        //The status for when the user is not authorized for making the request
                        401: function (ressponse) {
                            location.reload();
                        },
                        403: function (response) {
                            window.location.replace("/403");
                        },
                        404: function (response) {
                            window.location.replace("/404");
                        },
                        //The status for when form data is not valid
                        422: function (response) {
                            //
                        },
                        //The status for when there is error php code
                        500: function (response) {
                            // console.log(response.responseText);
                            // toastr["error"]("خطای برنامه!", "پیام سیستم");
                        },
                        //The status for when there is error php code
                        503: function (response) {
                            // toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                        }
                    }
                });

                return false;
            }

        });
    </script>
@endsection