
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- begin::seo meta tags -->
{!! SEO::generate(true) !!}
<!-- end:: seo meta tags -->

<!--begin::Web font -->
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
<script>
    WebFont.load({
        google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
        active: function () {
            sessionStorage.fonts = true;
        }
    });
</script>
<!--end::Web font -->

<!--begin::Global Theme Styles -->
<link href="{{ mix('/css/all.css') }}" rel="stylesheet" type="text/css"/>
<!--end::Global Theme Styles -->

@yield('page-css')

@if(isset($wSetting->site->favicon))
    <link rel="shortcut icon" href="{{route('image', ['category'=>'11','w'=>'150' , 'h'=>'150' ,  'filename' =>  $wSetting->site->favicon ])}}"/>
@endif
<!--begin: csrf token -->
<script>
    window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
                ]) !!};
</script>
<!--end: csrf token -->
@include('partials.gtm-head')