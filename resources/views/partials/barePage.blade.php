@extends('app' , ['pageName' => ((isset($pageName)) ? $pageName : ''), 'appBodyClass' => ((isset($bodyClass)) ? $bodyClass : '')])

@section('app-page-head')
    @include('partials.html-head')
    @yield('bare-page-head')
@endsection

@section('app-page-body')
    @if(config('gtm.GTM'))
        @include('partials.gtm-body')
    @endif

    @include('partials.app.globalJsVar')

    @yield('bare-page-body')

    <script src="{{ mix('/js/all.js') }}" type="text/javascript"></script>
    @yield('bare-page-js')
@endsection
