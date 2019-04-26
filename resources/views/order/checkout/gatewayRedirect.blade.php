<!DOCTYPE html>
<html lang = "fa" direction = "rtl" style = "direction: rtl">
<!-- begin::Head -->
<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name = "csrf-token" content = "{{ csrf_token() }}">

    <!--begin::Global Theme Styles -->
    <link href = "{{ mix('/css/all.css') }}" rel = "stylesheet" type = "text/css"/>
    <!--end::Global Theme Styles -->
    <style>
        body {
            background-image: linear-gradient(to left, #00bcff, #00d1ff, #00e4f2, #00f4ce, #00ff9b);
        }
    </style>
    <style>
        #spinningSquaresG {
            position: relative;
            width: 168px;
            height: 20px;
            margin: auto;
        }

        .spinningSquaresG {
            position: absolute;
            top: 0;
            background-color: rgb(34, 255, 0);
            width: 20px;
            height: 20px;
            animation-name: bounce_spinningSquaresG;
            -o-animation-name: bounce_spinningSquaresG;
            -ms-animation-name: bounce_spinningSquaresG;
            -webkit-animation-name: bounce_spinningSquaresG;
            -moz-animation-name: bounce_spinningSquaresG;
            animation-duration: 1.165s;
            -o-animation-duration: 1.165s;
            -ms-animation-duration: 1.165s;
            -webkit-animation-duration: 1.165s;
            -moz-animation-duration: 1.165s;
            animation-iteration-count: infinite;
            -o-animation-iteration-count: infinite;
            -ms-animation-iteration-count: infinite;
            -webkit-animation-iteration-count: infinite;
            -moz-animation-iteration-count: infinite;
            animation-direction: normal;
            -o-animation-direction: normal;
            -ms-animation-direction: normal;
            -webkit-animation-direction: normal;
            -moz-animation-direction: normal;
            transform: scale(.3);
            -o-transform: scale(.3);
            -ms-transform: scale(.3);
            -webkit-transform: scale(.3);
            -moz-transform: scale(.3);
        }

        #spinningSquaresG_1 {
            left: 0;
            animation-delay: 0.466s;
            -o-animation-delay: 0.466s;
            -ms-animation-delay: 0.466s;
            -webkit-animation-delay: 0.466s;
            -moz-animation-delay: 0.466s;
        }

        #spinningSquaresG_2 {
            left: 21px;
            animation-delay: 0.5825s;
            -o-animation-delay: 0.5825s;
            -ms-animation-delay: 0.5825s;
            -webkit-animation-delay: 0.5825s;
            -moz-animation-delay: 0.5825s;
        }

        #spinningSquaresG_3 {
            left: 42px;
            animation-delay: 0.699s;
            -o-animation-delay: 0.699s;
            -ms-animation-delay: 0.699s;
            -webkit-animation-delay: 0.699s;
            -moz-animation-delay: 0.699s;
        }

        #spinningSquaresG_4 {
            left: 63px;
            animation-delay: 0.8155s;
            -o-animation-delay: 0.8155s;
            -ms-animation-delay: 0.8155s;
            -webkit-animation-delay: 0.8155s;
            -moz-animation-delay: 0.8155s;
        }

        #spinningSquaresG_5 {
            left: 84px;
            animation-delay: 0.932s;
            -o-animation-delay: 0.932s;
            -ms-animation-delay: 0.932s;
            -webkit-animation-delay: 0.932s;
            -moz-animation-delay: 0.932s;
        }

        #spinningSquaresG_6 {
            left: 105px;
            animation-delay: 1.0485s;
            -o-animation-delay: 1.0485s;
            -ms-animation-delay: 1.0485s;
            -webkit-animation-delay: 1.0485s;
            -moz-animation-delay: 1.0485s;
        }

        #spinningSquaresG_7 {
            left: 126px;
            animation-delay: 1.165s;
            -o-animation-delay: 1.165s;
            -ms-animation-delay: 1.165s;
            -webkit-animation-delay: 1.165s;
            -moz-animation-delay: 1.165s;
        }

        #spinningSquaresG_8 {
            left: 147px;
            animation-delay: 1.2915s;
            -o-animation-delay: 1.2915s;
            -ms-animation-delay: 1.2915s;
            -webkit-animation-delay: 1.2915s;
            -moz-animation-delay: 1.2915s;
        }


        @keyframes bounce_spinningSquaresG {
            0% {
                transform: scale(1);
                background-color: rgb(34, 255, 0);
            }

            100% {
                transform: scale(.3) rotate(90deg);
                background-color: rgb(0, 255, 213);
            }
        }

        @-o-keyframes bounce_spinningSquaresG {
            0% {
                -o-transform: scale(1);
                background-color: rgb(34, 255, 0);
            }

            100% {
                -o-transform: scale(.3) rotate(90deg);
                background-color: rgb(0, 255, 213);
            }
        }

        @-ms-keyframes bounce_spinningSquaresG {
            0% {
                -ms-transform: scale(1);
                background-color: rgb(34, 255, 0);
            }

            100% {
                -ms-transform: scale(.3) rotate(90deg);
                background-color: rgb(0, 255, 213);
            }
        }

        @-webkit-keyframes bounce_spinningSquaresG {
            0% {
                -webkit-transform: scale(1);
                background-color: rgb(34, 255, 0);
            }

            100% {
                -webkit-transform: scale(.3) rotate(90deg);
                background-color: rgb(0, 255, 213);
            }
        }

        @-moz-keyframes bounce_spinningSquaresG {
            0% {
                -moz-transform: scale(1);
                background-color: rgb(34, 255, 0);
            }

            100% {
                -moz-transform: scale(.3) rotate(90deg);
                background-color: rgb(0, 255, 213);
            }
        }
    </style>
</head>
<body>


<div class = "container">
    <div class = "row align-items-center m--margin-top-100">
        <div class = "col align-self-center text-center">
            <img src = "{{ asset('acm/extra/payment/gateway/zarinpal.png') }}" class = "img-responsive img-thumbnail rounded">
        </div>
        <div class = "col align-self-center text-center">
            <div id = "spinningSquaresG">
                <div id = "spinningSquaresG_1" class = "spinningSquaresG"></div>
                <div id = "spinningSquaresG_2" class = "spinningSquaresG"></div>
                <div id = "spinningSquaresG_3" class = "spinningSquaresG"></div>
                <div id = "spinningSquaresG_4" class = "spinningSquaresG"></div>
                <div id = "spinningSquaresG_5" class = "spinningSquaresG"></div>
                <div id = "spinningSquaresG_6" class = "spinningSquaresG"></div>
                <div id = "spinningSquaresG_7" class = "spinningSquaresG"></div>
                <div id = "spinningSquaresG_8" class = "spinningSquaresG"></div>
            </div>
        </div>
        <div class = "col align-self-center text-center">
            <img src = "{{ asset('acm/extra/Alaa-logo.gif') }}" class = "img-responsive">
        </div>
    </div>
</div>

{!! Form::open(['method' => $redirectData->getMethod(), 'url' => $redirectData->getRedirectUrl()]) !!}
@foreach($redirectData->getInput() as $input)
    {!! Form::hidden($input['name'],$input['value']) !!}
@endforeach
{!! Form::close() !!}
<!--begin::Global Theme Bundle -->
<script src = "{{ mix('/js/all.js') }}" type = "text/javascript"></script>
<!--end::Global Theme Bundle -->
<script type = "text/javascript">

    $(document).ready(function () {
        setTimeout(function () {
            $('form').submit();
        }, 4000);
    });

</script>
</body>
</html>

