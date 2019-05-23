{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    <title>Be right back.</title>--}}
{{--    <link href = "/acm/extra/fonts/IRANSans/css/fontiran.css" rel = "stylesheet" type = "text/css"/>--}}
{{--    <link href = "/acm/extra/fonts/IRANSans/css/style.css" rel = "stylesheet" type = "text/css"/>--}}
{{--    --}}{{--<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">--}}

{{--    <style>--}}
{{--        html, body {--}}
{{--            height: 100%;--}}
{{--        }--}}

{{--        body {--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--            width: 100%;--}}
{{--            color: #B0BEC5;--}}
{{--            display: table;--}}
{{--            font-weight: 100;--}}
{{--            font-family: 'Lato', sans-serif;--}}
{{--        }--}}

{{--        .container {--}}
{{--            text-align: center;--}}
{{--            display: table-cell;--}}
{{--            vertical-align: middle;--}}
{{--        }--}}

{{--        .content {--}}
{{--            text-align: center;--}}
{{--            display: inline-block;--}}
{{--        }--}}

{{--        .title {--}}
{{--            font-size: 72px;--}}
{{--            margin-bottom: 40px;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class = "container">--}}
{{--    <div class = "content">--}}
{{--        <div class = "title" dir = "rtl">سایت در حال بروز رسانی می باشد . از شکیبایی شما متشکریم!</div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}


<!DOCTYPE html>
<html lang="fa" direction="rtl" style="direction: rtl">
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8"/>
        <title>بروز رسانی</title>
        <meta name="description" content="سایت در حال بروز رسانی است.">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <link href="{{ asset('/acm/webFonts/IRANSans/css/fontiran.css') }}" rel="stylesheet" type="text/css"/>
        <style>
            html, body {
                height: 100%;
                padding: 0;
                margin: 0;
            }
            body {
                font-family: IRANSans;
                display: flex;
                justify-content: center;
                align-items: center;
                background: #4dbbe9;
                color: white;
            }
        </style>
    </head>
    <!-- end::Head -->
    
    <!-- begin::Body -->
    <body>
        <!-- begin:: Page -->
        <div class="img">
            <img src="{{ asset('/acm/extra/wesite-under-Construction.png') }}" alt="wesite-under-Construction" >
        </div>
        <div class="message">
            <h1 class="m-error_description m--font-light">
                سایت در حال بروز رسانی می باشد.
            </h1>
            <h3>
                از شکیبایی شما متشکریم!
            </h3>
        </div>
        <!-- end:: Page -->
    </body>
    <!-- end::Body -->
</html>