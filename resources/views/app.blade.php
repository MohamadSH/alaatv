<!DOCTYPE html>
<html lang="fa" direction="rtl" style="direction: rtl">
    <head>
        @yield('app-page-head')
    </head>
    <body @if(isset($appBodyClass)) class="{{$appBodyClass}}" @endif>
        @yield('app-page-body')
    </body>
</html>
