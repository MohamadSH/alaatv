@extends("app")

@section("pageBar")

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
                                            <span class="m-badge m-badge--info m-badge--wide">
                                                @if($paymentMethod === 'zarinpal')
                                                    درگاه زرین پال
                                                @elseif($paymentMethod === 'mellat')
                                                    درگاه به پرداخت ملت
                                                @elseif($paymentMethod === 'wallet')
                                                    کیف پول
                                                @endif
                                            </span>
        
                                            <hr>
                                            
                                            @if($status === 'successful')
                                                @if(isset($result['RefID']))
                                                    کد پیگیری
                                                    <br>
                                                    <span class="m-badge m-badge--info m-badge--wide" dir="ltr">
                                                        {{ $result['RefID'] }}
                                                    </span>
                                                @endif
                                                
                                                @if(isset($result['cardPanMask']))
                                                    <hr>
                                                    شماره کارت
                                                    <span class="m-badge m-badge--info m-badge--wide" dir="ltr">
                                                        {{ $result['cardPanMask'] }}
                                                    </span>
                                                @endif
                                            @endif
                                        @else
                                        
                                        @endif
                                    </span>
                                </a>
                                <a href="{{ asset('/') }}"><img src="{{ asset('/acm/extra/Alaa-logo.png') }}"
                                                                alt="آلاء"></a>
                            </div>
                            <span class="m-invoice__desc">

                                @if(isset($result['messages']))
                                    <div class="alert
                                        @if($status==='successful')
                                            alert-success
                                        @else
                                            alert-warning
                                        @endif
                                            alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close"></button>
                                        @foreach($result['messages'] as $message)
                                            {!!  $message !!}
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
    <script>
        var gtmEec = {!! json_encode($gtmEec) !!};
        var paymentStatus =
        @if($status==='successful')
            true;
        @else
            false
        @endif
        ;
    </script>
    <script src="{{ mix('/js/checkout-verification.js') }}"></script>
    
    <input id="js-var-order-id" class="m--hide" type="hidden" value='{{ $result['orderId'] ?? -1 }}'>
    <input id="js-var-paid-price" class="m--hide" type="hidden" value='{{ $result['paidPrice'] ?? 1 }}'>
    <script>
        jQuery(document).ready(function () {
            var orderIdValue = $('#js-var-order-id').val();
            var paidPriceValue = $('#js-var-paid-price').val();
            dataLayer.push(
                {
                    'orderId': orderIdValue,
                    'paidPrice': paidPriceValue,
                });
        });
    </script>
@endsection