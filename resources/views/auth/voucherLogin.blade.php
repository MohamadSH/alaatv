@extends('partials.barePage' , ['pageName' => 'voucherLogin'])

@section('bare-page-head')
    <link href="{{ mix('/css/voucher-login.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('bare-page-body')
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

@section('bare-page-js')
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
    <script src = "{{ mix('/js/voucher-login.js') }}"></script>
@endsection
