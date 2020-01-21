@extends('barePage' , ['pageName' => 'voucherLogin'])

@section('page-css')
{{--    <link href="{{ mix('/css/page-contactUs.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('/acm/AlaatvCustomFiles/css/auth/voucherLogin.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

@endsection


@section('page-js')
{{--    <script src = "{{ mix('/js/contactUs.js') }}"></script>--}}
    <script src = "{{ asset('/acm/AlaatvCustomFiles/js/auth/voucherLogin.js') }}"></script>
@endsection
