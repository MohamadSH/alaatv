@extends("app")

@section("pageBar")

@endsection

@section('page-css')
    {{--<link href = "{{ mix('/css/checkout-review.css') }}" rel = "stylesheet" type = "text/css"/>--}}
    {{--<link href = "{{ asset('/acm/AlaatvCustomFiles/components/step/step.css') }}" rel = "stylesheet" type = "text/css"/>--}}
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item">
                <i class = "flaticon-photo-camera m--padding-right-5"></i>
                <a class = "m-link" href = "{{ action("Web\UserController@userOrders") }}">سفارش های من</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#"> رسید پرداخت </a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="m-portlet">
        <div class="m-portlet__body m-portlet__body--no-padding">
            <div class="m-invoice-1">
                <div class="m-invoice__wrapper">
                    <div class="m-invoice__head" style="background-image: url(/assets/app/media/img//bg/bg-6.jpg);">
                        <div class="m-invoice__container m-invoice__container--centered">
                            <div class="m-invoice__logo">
                                <a href="#">
                                    <h1>INVOICE</h1>
                                </a>
                                <a href="#">
                                    <img src="/assets/app/media/img//logos/logo_client_white.png">
                                </a>
                            </div>
                            <span class="m-invoice__desc">
							<span>Cecilia Chapman, 711-2880 Nulla St, Mankato</span>
							<span>Mississippi 96522</span>
						</span>
                            <div class="m-invoice__items">
                                <div class="m-invoice__item">
                                    <span class="m-invoice__subtitle">DATA</span>
                                    <span class="m-invoice__text">Dec 12, 2017</span>
                                </div>
                                <div class="m-invoice__item">
                                    <span class="m-invoice__subtitle">INVOICE NO.</span>
                                    <span class="m-invoice__text">GS 000014</span>
                                </div>
                                <div class="m-invoice__item">
                                    <span class="m-invoice__subtitle">INVOICE TO.</span>
                                    <span class="m-invoice__text">Iris Watson, P.O. Box 283 8562 Fusce RD.<br>Fredrick Nebraska 20620</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-invoice__body m-invoice__body--centered">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>DESCRIPTION</th>
                                    <th>HOURS</th>
                                    <th>RATE</th>
                                    <th>AMOUNT</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Creative Design</td>
                                    <td>80</td>
                                    <td>$40.00</td>
                                    <td>$3200.00</td>
                                </tr>
                                <tr>
                                    <td>Front-End Development</td>
                                    <td>120</td>
                                    <td>$40.00</td>
                                    <td>$4800.00</td>
                                </tr>
                                <tr>
                                    <td>Back-End Development</td>
                                    <td>210</td>
                                    <td>$60.00</td>
                                    <td>$12600.00</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="m-invoice__footer">
                        <div class="m-invoice__container m-invoice__container--centered">
                            <div class="m-invoice__content">
                                <span>BANK TRANSFER</span>
                                <span><span>Account Name:</span><span>Barclays UK</span></span>
                                <span><span>Account Number:</span><span>1234567890934</span></span>
                                <span><span>Code:</span><span>BARC0032UK</span></span>
                            </div>
                            <div class="m-invoice__content">
                                <span>TOTAL AMOUNT</span>
                                <span class="m-invoice__price">$20.600.00</span>
                                <span>Taxes Included</span>
                            </div>
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