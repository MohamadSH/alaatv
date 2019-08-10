<link rel="dns-prefetch" href="//alaatv.com">
<link rel="dns-prefetch" href="//cdn.alaatv.com">
<link rel="dns-prefetch" href="//www.googletagmanager.com">
<link rel="dns-prefetch" href="//www.google-analytics.com">
<link rel="dns-prefetch" href="//app.najva.com">

<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="theme-color" content="#ff9000" />
{{--<link rel="manifest" href="/manifest.json">--}}


<!-- begin::seo meta tags -->
{!! SEO::generate(true) !!}
<!-- end:: seo meta tags -->

<script>
    // csrf token
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
</script>

<!--begin::Global Theme Styles -->
<link href="{{ mix('/css/all.css') }}" rel="stylesheet" type="text/css"/>
<style>
    .a--owl-carousel-row .a--owl-carousel-Wraper .a--block-item.a--block-type-set .a--block-imageWrapper .a--block-detailesWrapper {
        z-index: 9;
    }
</style>
<!--end::Global Theme Styles -->

@yield('page-css')

@if(isset($wSetting->site->favicon))
    <link rel="shortcut icon" href="https://cdn.alaatv.com/upload/favicon2_20190508061941_20190512113140.ico"/>
@endif

@if(config('gtm.GTM'))
    @include('partials.gtm-head')
@endif
