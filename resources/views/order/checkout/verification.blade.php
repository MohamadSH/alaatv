@extends("app")

@section("pageBar")

@endsection

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("title")
    <title>آلاء|بازبینی سفارش</title>
@endsection


@section("gtagJs")
    {{--@if(strcmp(array_get($result,"Status"),'success')==0)--}}
        {{--<!-- Event snippet for Make-A-Payment conversion page -->--}}
        {{--<script>--}}
            {{--gtag('event', 'conversion', {--}}
                {{--'send_to': 'AW-927952751/0L57COfS9YEBEO_evboD',--}}
                {{--'transaction_id': ''--}}
            {{--});--}}
        {{--</script>--}}
    {{--@endif--}}
@endsection
@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered ">
                <div class="portlet-title">
                <div class="caption">
                <i class=" icon-layers font-green"></i>
                <span class="caption-subject font-green bold uppercase">پایان سفارش</span>
                </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="portlet @if(strcmp(array_get($result,"Status"),'error')==0) red-sunglo @elseif(strcmp(array_get($result,"Status"),'canceled')==0) yellow @else green-meadow @endif box">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="@if(strcmp(array_get($result,"Status"),'error')==0) fa fa-times @elseif(strcmp(array_get($result,"Status"),'canceled')==0) fa fa-exclamation-triangle @else fa fa-check @endif "></i>
                                        @if(strcmp(array_get($result,"Status"),'error')==0)خطا
                                        @elseif(strcmp(array_get($result,"Status"),'canceled')==0)ناموفق
                                        @else @if(isset($result["isAdminOrder"]) && $result["isAdminOrder"]) پایان ثبت سفارش @else از انتخاب شما متشکریم! @endif
                                        @endif </div>
                                </div>
                                <div class="portlet-body">
                                    @if(strcmp(array_get($result,"Status"),'success')==0)
                                        <div class="row static-info">
                                            <div class="col-md-12 " style="text-align: center">
                                                @if(array_get($result,"saveOrder"))
                                                    <h3 class="bold">پرداخت شما با موفقیت انجام شد</h3>
                                                @else
                                                    <h4 class="bold">پرداخت شما موفقیت آمیز بوداما ثبت بسته ی شما با خطا روبرو شد. لطفاجهت پیگیری با ما تماس بگیرید.</h4>
                                                @endif
                                                @if(array_get($result,"saveBon") > 0)
                                                    <h3 class="bold">تعداد {{array_get($result,"saveBon")}} {{array_get($result,"bonName")}} به شما تعلق گرفت</h3>
                                                @elseif(array_get($result,"saveBon") == -1)
                                                        <h3 class="bold">خطایی در اختصاص تعداد {{array_get($result,"saveBon")}} {{array_get($result,"bonName")}} رخ داد، لطفا به مسئولین سایت گزارش دهید.</h3>
                                                @endif
                                                    <p>شما می توانید اطلاعات این سفارش را در  <a href="{{action('UserController@userOrders')}}" class="btn blue btn-outline">لیست سفارشات خود</a> (از منوی بالای صفحه) مشاهده نمایید .</p>
                                            </div>
                                        </div>
                                        <div class="row static-info " style="text-align: center;">
                                                <span class="label label-success" style="font-size: 15px">شماره تراکنش شما: {{array_get($result,"RefID")}} </span>
                                        </div>
                                    @elseif(strcmp(array_get($result,"Status"),'canceled')==0)
                                        <div class="row static-info">
                                            <div class="col-md-12 " style="text-align: center">
                                                    <h3 class="bold">پرداخت شما ناموفق بود</h3>
                                                <p>شما می توانید اطلاعات این سفارش را با رفتن به  <a href="{{action('UserController@userOrders')}}" class="btn blue btn-outline">لیست سفارش های خود</a> از طریق منوی بالای صفحه مشاهده نمایید .</p>
                                                    @if($result["tryAgain"])<a href="{{action("OrderController@checkoutAuth")}}"   class="btn green btn-outline">پرداخت مجدد</a>@endif
                                            </div>
                                        </div>
                                    @elseif(strcmp(array_get($result,"Status"),'error')==0)
                                        <div class="row static-info">
                                            @if(strcmp(array_get($result,"error"),'101')==0)
                                                <div class="col-md-12 " style="text-align: center">
                                                        <h2 class="bold">تراکنش قبلا تایید شده است</h2>
                                                </div>
                                            @elseif(strcmp(array_get($result,"error"),'-33')==0)
                                                <div class="col-md-12 " style="text-align: center">
                                                    <h3 class="bold">رقم تراکنش با رقم پرداخت مطابقت ندارد</h3>
                                                </div>
                                            @elseif(strcmp(array_get($result,"error"),'-21')==0)
                                                <div class="col-md-12 " style="text-align: center">
                                                    <h3 class="bold">هیچ نوع عملیات مالی برای این تراکنش یافت نشد</h3>
                                                </div>
                                            @elseif(strcmp(array_get($result,"error"),'-11')==0)
                                                <div class="col-md-12 " style="text-align: center">
                                                    <h2 class="bold">درخواست مورد نظر یافت نشد</h2>
                                                </div>
                                            @elseif(strcmp(array_get($result,"error"),'-2')==0)
                                                <div class="col-md-12 " style="text-align: center">
                                                    <h3 class="bold">اطلاعات سایت پذیرنده غلط است</h3>
                                                </div>
                                            @elseif(strcmp(array_get($result,"error"),'-1')==0)
                                                <div class="col-md-12 " style="text-align: center">
                                                    <h3 class="bold">مبلغ تراکنش تطابق ندارد</h3>
                                                </div>
                                            @else
                                                <div class="col-md-12 " style="text-align: center">
                                                    <h3 class="bold">وضعیت پرداخت شما ناشناخته است</h3>
                                                </div>
                                            @endif
                                        </div>
                                    @elseif(strcmp(array_get($result,"Status"),'inPersonPayment')==0)
                                        <div class="row static-info">
                                            <div class="col-md-12 " style="text-align: center">
                                                @if(array_get($result,"saveOrder"))
                                                    @if(isset($result["isAdminOrder"]) && $result["isAdminOrder"])
                                                        <h3 class="bold">سفارش برای {{$result["customer_firstName"]}} {{$result["customer_lastName"]}} با موفقیت ثبت شد</h3>
                                                        <p>شما هم اکنون می توانید بار رفرش دادن لیست سفارشات در پنل مدیریتی ، سفارش ایشان را در لیست مشاهده نمایید</p>
                                                        <span class="label label-warning">توجه</span>
                                                        <strong id="">شما از وضعیت درج سفارش برای {{$result["customer_firstName"]}} {{$result["customer_lastName"]}} خارج شده اید</strong>
                                                    @else
                                                        <h3 class="bold">سفارش شما با موفقیت ثبت شد</h3>
                                                    @endif
                                                @else
                                                    @if(isset($result["isAdminOrder"]) && $result["isAdminOrder"])
                                                        <h4 class="bold">متاسفانه خطایی در ثبت سفارش برای {{$result["customer_firstName"]}} {{$result["customer_lastName"]}} اتفاق افتاد لطفا دوباره اقدام نمایید.</h4>
                                                    @else
                                                        <h4 class="bold">متاسفانه خطایی در ثبت سفارش شما اتفاق افتاد لطفا دوباره اقدام نمایید.</h4>
                                                    @endif

                                                    <a href="{{action("OrderController@checkoutAuth")}}"   class="btn green btn-outline">ثبت مجدد</a>
                                                @endif
                                                @if(isset($result["isAdminOrder"]) && !$result["isAdminOrder"])
                                                    <p class="font-red-thunderbird">یک تاریخ برای مراجعه حضوری به شما اعلام خواهد شد. توجه داشته باشید که تا لحظه تسویه حساب حضوری بن محصول به شما تعلق نخواهد گرفت!</p>
                                                    <p>همچنین شما می توانید اطلاعات این سفارش را با رفتن به  <a href="{{action('UserController@userOrders')}}" class="btn blue btn-outline">لیست سفارش های خود</a> از طریق منوی بالای صفحه مشاهده نمایید و <span class="font-red-thunderbird">در صورت تمایل نصبت به پرداخت آنلاین آن اقدام نمایید و یا در صورت پرداخت کارت به کارت ، اطلاعات رسید عابر بانک را برای این سفارش وارد نمایید</span></p>
                                                        @if(isset($result["debitCardNumber"]))<p class="list-group-item  bg-blue-soft bg-font-blue-soft"> واریز شود به کارت :<span dir="ltr">{{$result["debitCardNumber"]}}</span>
                                                            به نام {{$result["debitCardOwner"]}} بانک {{$result["debitCardBank"]}}</p>@endif
                                                @endif
                                            </div>
                                        </div>
                                    @elseif(strcmp(array_get($result,"Status"),'offlinePayment')==0)
                                        <div class="row static-info">
                                            <div class="col-md-12 " style="text-align: center">
                                                @if(array_get($result,"saveOrder"))
                                                    @if(isset($result["isAdminOrder"]) && $result["isAdminOrder"])
                                                        <h3 class="bold">سفارش برای {{$result["customer_firstName"]}} {{$result["customer_lastName"]}} با موفقیت ثبت شد</h3>
                                                        <p>شما هم اکنون می توانید بار رفرش دادن لیست سفارشات در پنل مدیریتی ، سفارش ایشان را در لیست مشاهده نمایید</p>
                                                        <span class="label label-warning">توجه</span>
                                                        <strong id="">شما از وضعیت درج سفارش برای {{$result["customer_firstName"]}} {{$result["customer_lastName"]}} خارج شده اید</strong>
                                                    @else
                                                        <h3 class="bold">سفارش شما با موفقیت ثبت شد</h3>
                                                    @endif
                                                @else
                                                    @if(isset($result["isAdminOrder"]) && $result["isAdminOrder"])
                                                        <h4 class="bold">متاسفانه خطایی در ثبت سفارش برای {{$result["customer_firstName"]}} {{$result["customer_lastName"]}} اتفاق افتاد لطفا دوباره اقدام نمایید.</h4>
                                                    @else
                                                        <h4 class="bold">متاسفانه خطایی در ثبت سفارش شما اتفاق افتاد لطفا دوباره اقدام نمایید.</h4>
                                                    @endif

                                                    <a href="{{action("OrderController@checkoutAuth")}}"   class="btn green btn-outline">ثبت مجدد</a>
                                                @endif
                                                @if(isset($result["isAdminOrder"]) &&  !$result["isAdminOrder"])
                                                    <p class="font-red-thunderbird">شما می توانید پس از واریز کارت به کارت مبلغ، اطلاعات رسید عابر بانک را با مراجعه به <a href="{{action('UserController@userOrders')}}" class="btn blue btn-outline">لیست سفارش های خود</a> برای این سفارش وارد نمایید تا مورد بررسی مسئولین سایت قرار گیرد. توجه داشته باشید که تا لحظه تسویه حساب  بن محصول به شما تعلق نخواهد گرفت!</p>
                                                    <p>همچنین شما می توانید با رفتن به لیست سفارشات ، در صورت تمایل نسبت به پرداخت آنلاین اقدام نمایید.</p>
                                                        @if(isset($result["debitCardNumber"]))<p class="list-group-item  bg-blue-soft bg-font-blue-soft"> واریز شود به کارت :<span dir="ltr">{{$result["debitCardNumber"]}}</span>
                                                            به نام {{$result["debitCardOwner"]}} بانک  {{$result["debitCardBank"]}}</p>@endif
                                                @endif
                                            </div>
                                        </div>
                                    @elseif(strcmp(array_get($result,"Status"),'freeProduct')==0)
                                        <div class="row static-info">
                                            <div class="col-md-12 " style="text-align: center">
                                                @if(array_get($result,"saveOrder"))
                                                    @if(isset($result["isAdminOrder"]) && $result["isAdminOrder"])
                                                        <h3 class="bold">سفارش برای {{$result["customer_firstName"]}} {{$result["customer_lastName"]}} با موفقیت ثبت شد</h3>
                                                        <p>شما هم اکنون می توانید بار رفرش دادن لیست سفارشات در پنل مدیریتی ، سفارش ایشان را در لیست مشاهده نمایید</p>
                                                        <span class="label label-warning">توجه</span>
                                                        <strong id="">شما از وضعیت درج سفارش برای {{$result["customer_firstName"]}} {{$result["customer_lastName"]}} خارج شده اید</strong>
                                                    @else
                                                        <h3 class="bold">سفارش شما با موفقیت ثبت شد</h3>
                                                    @endif
                                                @else
                                                    @if(isset($result["isAdminOrder"]) && $result["isAdminOrder"])
                                                        <h4 class="bold">متاسفانه خطایی در ثبت سفارش برای {{$result["customer_firstName"]}} {{$result["customer_lastName"]}} اتفاق افتاد لطفا دوباره اقدام نمایید.</h4>
                                                    @else
                                                        <h4 class="bold">متاسفانه خطایی در ثبت سفارش شما اتفاق افتاد لطفا دوباره اقدام نمایید.</h4>
                                                    @endif
                                                    <a href="{{action("OrderController@checkoutAuth")}}"   class="btn green btn-outline">ثبت مجدد</a>
                                                @endif
                                                @if(isset($result["isAdminOrder"]) &&  !$result["isAdminOrder"])
                                                    <p class="font-red-thunderbird"><a href="{{action('UserController@userOrders')}}" class="btn blue btn-outline">لیست سفارشهای شما</a></p>
                                                @endif
                                            </div>
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