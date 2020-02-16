@extends('partials.templatePage')

@section('page-css')
    {{--<link href = "{{ mix('/css/checkout-review.css') }}" rel = "stylesheet" type = "text/css"/>--}}
    <link href = "{{ asset('/acm/AlaatvCustomFiles/components/step/step.css') }}" rel = "stylesheet" type = "text/css"/>
@endsection

@section('content')

    @include("partials.checkoutSteps" , ["step"=>0])

    @include('systemMessage.flash')

    <div class = "container">
        <div class = "row align-items-center">
            <div class = "col-12 col-sm-9 col-md-6 col-lg-5 mx-auto">

                <div class = "m-portlet m-portlet--bordered m-portlet--last">
                    <div class = "m-portlet__head">
                        <div class = "m-portlet__head-caption">
                            <div class = "m-portlet__head-title">
                                <h3 class = "m-portlet__head-text">
                                    ورود
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class = "m-portlet__body">

                        @include("partials.loginForm")

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('page-js')
    c
    @if(!empty($errors->getBags()))
        <script>
            jQuery(document).ready(function () {
                @if(!$errors->login->isEmpty())
                $("#signin-button").trigger("click");
                @else
                $("#signup-button").trigger("click");
                @endif
            });
        </script>
    @endif
@endsection
