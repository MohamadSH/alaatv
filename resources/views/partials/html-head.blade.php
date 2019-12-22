<link rel="dns-prefetch" href="//alaatv.com">
<link rel="dns-prefetch" href="//cdn.alaatv.com">
<link rel="dns-prefetch" href="//www.googletagmanager.com">
<link rel="dns-prefetch" href="//www.google-analytics.com">
<link rel="dns-prefetch" href="//app.najva.com">

<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">

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

<link rel="preload" href="/acm/webFonts/IRANSans/farsi_numeral/woff2/IRANSansWeb(FaNum)_Light.woff2" as="font" type="font/woff2" crossOrigin="anonymous" >
<link rel="preload" href="/css/fonts/fontawesome5/fa-solid-900.woff2" as="font" type="font/woff2" crossOrigin="anonymous" >
<link rel="preload" href="/css/fonts/fontawesome5/fa-brands-400.woff2" as="font" type="font/woff2" crossOrigin="anonymous" >

<link rel="preload" href="{{ mix('/css/all.css') }}" as="style" />

@yield('page-preload-css')

<link rel="preload" href="{{ mix('/js/all.js') }}" as="script">
@yield('page-preload-js')

<!--begin::Global Theme Styles -->
<link href="{{ mix('/css/all.css') }}" rel="stylesheet" />
<!--end::Global Theme Styles -->

@yield('page-css')

@if(isset($wSetting->site->favicon))
    <link rel="shortcut icon" href="https://cdn.alaatv.com/upload/favicon2_20190508061941_20190512113140.ico"/>
@endif

@if(config('gtm.GTM'))
    @include('partials.gtm-head')
@endif
