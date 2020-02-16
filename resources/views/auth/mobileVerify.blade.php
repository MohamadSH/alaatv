@extends('partials.templatePage',["pageName"=>"rules"])

@section("css")
    <link rel = "stylesheet" href = "{{ mix('/css/all.css') }}">
@endsection

@section("title")
    <title>@if(isset($wSetting->site->name)) {{$wSetting->site->name}} @endif|تایید شماره موبایل</title>
@endsection

@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{route('web.index')}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>تایید شماره موبایل</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-12">
            <div class = "portlet light portlet-fit solid">
                <div class = "portlet-title">
                    {{ __('verification.Verify Your Mobile Number') }}
                </div>
                <div class = "portlet-body">
                    @if (session('resent'))
                        <div class = "alert alert-success" role = "alert">
                            {{ __('verification.A fresh verification code has been sent to your mobile number.') }}
                        </div>
                    @endif
                    {{ __('verification.Before proceeding, please check your mobile for a verification code.') }}
                    {{ __('verification.If you did not receive the code') }},
                    <a href = "{{ route('verification.resend') }}">{{ __('verification.click here to request another') }}</a>
                                                                            .
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT HEADER -->
@endsection

