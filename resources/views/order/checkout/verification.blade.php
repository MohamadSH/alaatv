@extends("app")

@section("pageBar")

@endsection

@section('page-css')
    {{--<link href = "{{ mix('/css/checkout-review.css') }}" rel = "stylesheet" type = "text/css"/>--}}
    {{--<link href = "{{ asset('/acm/AlaatvCustomFiles/components/step/step.css') }}" rel = "stylesheet" type = "text/css"/>--}}
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item">
                <i class="flaticon-photo-camera m--padding-right-5"></i>
                <a class="m-link" href="{{ action("Web\UserController@userOrders") }}">سفارش های من</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#"> رسید پرداخت</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    
    <div class="m-portlet">
        <div class="m-portlet__body m-portlet__body--no-padding">
            <div class="m-invoice-1">
                <div class="m-invoice__wrapper">
                    <div class="m-invoice__head">
                        <div class="m-invoice__container m-invoice__container--centered">
                            <div class="m-invoice__logo">
                                <a href="#">
                                    <h1 class="m--font-primary">رسید پرداخت</h1>
                                    <br>
                                    <span class="m--font-primary">
                                        @if($result!=null)
                                            روش پرداخت
                                            <br>
                                            @if($paymentMethod === 'zarinpal')
                                                <span class="m-badge m-badge--info m-badge--wide">
                                                    درگاه زرین پال
                                                </span>
                                            @endif
                                            <hr>
                                            
                                            @if($status === 'successful')
                                                کد پیگیری
                                                <br>
                                                {{--                                                @if($paymentMethod === 'zarinpal')--}}
                                                @if(isset($result['zarinpalVerifyResult']['data']['RefID']))
                                                    <span class="m-badge m-badge--info m-badge--wide">
                                                        {{ $result['zarinpalVerifyResult']['data']['RefID'] }}
                                                    </span>
                                                @endif
                                                
                                                @if($paymentMethod === 'zarinpal' && isset($result['zarinpalVerifyResult']['data']['cardPanMask']))
                                                    <hr>
                                                    شماره کارت
                                                    <span class="m-badge m-badge--info m-badge--wide">
                                                        {{ $result['zarinpalVerifyResult']['data']['cardPanMask'] }}
                                                    </span>
                                                @endif
                                            @endif
                                        @else
                                        
                                        @endif
                                    </span>
                                </a>
                                <a href="#">
                                    <img src="{{ asset('/acm/extra/Alaa-logo.gif') }}">
                                </a>
                            </div>
                            <span class="m-invoice__desc">

                                @if($paymentMethod === 'zarinpal' && isset($result['zarinpalVerifyResult']['message']))
                                    <div class="alert
                                        @if($status==='successful')
                                            alert-success
                                        @else
                                            alert-warning
                                        @endif
                                            alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        </button>
                                            @foreach($result['zarinpalVerifyResult']['message'] as $message)
                                            {{ $message }}
                                            <br>
                                        @endforeach
                                    </div>
                                @endif
                                @if(isset($result['OrderSuccessPaymentResult']['saveOrder']) && $result['OrderSuccessPaymentResult']['saveOrder']!=1)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        </button>
                                        پرداخت شما با موفقیت انجام شده است، اما روند ثبت آن دچار مشکل شده است. لطفا با پشتیبانی سایت تماس بگیرید.
                                    </div>
                                @endif
                                
                                @if(isset($result['OrderSuccessPaymentResult']['saveBon']) && $result['OrderSuccessPaymentResult']['saveBon']>0)
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        </button>
                                        به شما تعداد {{ $result['OrderSuccessPaymentResult']['saveBon'] }} بن به نام {{{$result['OrderSuccessPaymentResult']['bonName']}}} تعلق گرفت.
                                    </div>
                                @endif

                            </span>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('page-js')
    {{--<script src = "{{ mix('/js/checkout-review.js') }}"></script>--}}
    {{--<script src="{{ asset('/acm/AlaatvCustomFiles/js/UserCart.js') }}"></script>--}}
    {{--<script src = "{{ asset('/acm/AlaatvCustomFiles/js/page-checkout-review.js') }}"></script>--}}
@endsection