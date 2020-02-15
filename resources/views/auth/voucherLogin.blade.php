@extends('barePage' , ['pageName' => 'voucherLogin'])

@section('page-css')
{{--    <link href="{{ mix('/css/page-contactUs.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('/acm/AlaatvCustomFiles/components/AlaaLoading/style.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/AlaatvCustomFiles/components/FormGenerator/style.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/AlaatvCustomFiles/css/auth/voucherLogin.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="row m--full-height align-items-center voucherPageFormWrapper d-none">
        <div class="col-md-6 mx-auto">
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                تایید شماره همراه
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="voucherPageForm">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-js')
    <script>
        var padeData = {
            login: {
                enable: {{($login) ? 'true' : 'false'}},
                loginActionUrl: GlobalJsVar.loginActionUrl(),
            },
            user: {
                mobile: '{{(isset($mobile) ? $mobile : '')}}'
            },
            verifyMobile: {
                enable: {{($verifyMobile) ? 'true' : 'false'}},
                sendVerificationCodeActionUrl: '{{ action('Web\MobileVerificationController@resend') }}',
                verifyActionUrl: '{{ action('Web\MobileVerificationController@verify') }}',
                verifyFormToken: '{{Session::token()}}',
                isVerified: {{((isset($isUserVerified) && $isUserVerified)) ? 'true' : 'false'}}
            },
            voucher: {
                enable: {{($voucher) ? 'true' : 'false'}},
                voucherActionUrl: '{{route('web.voucher.submit')}}',
                voucherCode: '{{(isset($code) ? $code : '')}}'
            },
            redirectUrl: '{{ $redirectUrl  }}'
        };
    </script>
{{--    <script src = "{{ mix('/js/contactUs.js') }}"></script>--}}
    <script src = "{{ asset('/acm/AlaatvCustomFiles/components/AlaaLoading/script.js') }}"></script>
    <script src = "{{ asset('/acm/AlaatvCustomFiles/components/FormGenerator/script.js') }}"></script>
    <script src = "{{ asset('/acm/AlaatvCustomFiles/js/auth/voucherLogin.js') }}"></script>
@endsection
