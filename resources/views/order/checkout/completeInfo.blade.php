@extends('partials.templatePage')

@section('page-css')
    <link href="{{ asset('/acm/AlaatvCustomFiles/components/step/step.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section("pageBar")

@endsection

@section("content")

    @include("partials.checkoutSteps" , ["step"=>1])

    @include('systemMessage.flash')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered ">
                {{--<div class="portlet-title">--}}
                {{--<div class="caption">--}}
                {{--<i class=" icon-layers font-green"></i>--}}
                {{--<span class="caption-subject font-green bold uppercase"></span>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="portlet-body">
                    <div class="row"></div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="portlet solid grey">
                                <div class="portlet-title">
                                    {{--<div class="caption">--}}
                                    {{--<i class="fa fa-pencil"></i>--}}
                                    {{--Portlet </div>--}}
                                </div>
                                <div class="portlet-body">
                                    @include("user.form" , ["formID"=>1 ])
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

@section('page-js')
    <script src="{{ mix('/js/checkout-completeInfo.js') }}"></script>
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
