<!DOCTYPE html>
<html lang="fa" direction="rtl" style="direction: rtl">
    <head>
        @include('partials.html-head')
        @yield('page-head')
    </head>
    <body @if(isset($bodyClass)) {{$bodyClass}} @endif>

        @if(config('gtm.GTM'))
            @include('partials.gtm-body')
        @endif

        @include('partials.app.globalJsVar')

        @yield('content')

        <script src="{{ mix('/js/all.js') }}" type="text/javascript"></script>
        @yield('page-js')
    </body>
</html>
