<!DOCTYPE html>
<html lang="fa" direction="rtl" style="direction: rtl">
    <!-- begin::Head -->
    <head>
        @include('partials.html-head')
        @yield('page-head')
    </head>
    <!-- end::Head -->

    <!-- begin::Body -->
    <body {{$bodyClass}}>

        @if(config('gtm.GTM'))
            @include('partials.gtm-body')
        @endif

        @include('partials.app.globalJsVar')


        @yield('content')


        <!--begin::Global Theme Bundle -->
        <script src="{{ mix('/js/all.js') }}" type="text/javascript"></script>
        <script>
            $(function () {
                /**
                 * Set token for ajax request
                 */
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken,
                    }
                });
            });
        </script>
        @yield('page-js')
    </body>
</html>
