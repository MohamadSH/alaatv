<!DOCTYPE html>
<html class = "no-js" lang = "fa-IR" dir = "rtl">
<head>
    <meta charset = "utf-8">
    {{--<title>Index2</title>--}}
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <meta name = "Designer" content = "Developed by Am!n">
    {!! SEO::generate(true) !!}
    <link rel = "stylesheet" href = "/acm/extra/schoolRegisterLanding/css/additionals.min.css">
    <link rel = "stylesheet" href = "/acm/extra/schoolRegisterLanding/css/styles.min.css">
    <style>
        @if($errors->has('grade_id'))
            .gradeSelect {
            border: solid red !important;
        }

        @endif
        @if($errors->has('major_id'))
            .majorSelect {
            border: solid red !important;
        }
        @endif
    </style>
    <script src = "/acm/extra/schoolRegisterLanding/js/jquery-2.2.4.min.js"></script>

    <!--[if lt IE 9]>
    <script type = 'text/javascript' src = '/acm/extra/schoolRegisterLanding/js/html5shiv.js'></script>
    <script type = 'text/javascript' src = '/acm/extra/schoolRegisterLanding/js/respond.min.js'></script><![endif]-->
    <script async src = "https://www.googletagmanager.com/gtag/js?id={{Config('constants.google.analytics')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        var dimensionValue = '{{ request()->ip() }}';

        gtag('js', new Date());

        gtag('config', "{{Config('constants.google.analytics')}}", {
            'custom_map': {'dimension2': 'dimension2'}
        });
        @if(Auth::check())
        gtag('set', {'user_id': '{{ Auth::user() ->id }}'}); // Set the user ID using signed-in user_id.
        @endif
        // Sends the custom dimension to Google Analytics.
        gtag('event', 'hit', {'dimension2': dimensionValue});
    </script>
    <script type = "text/javascript" src = "https://s1.mediaad.org/serve/549/retargeting.js" defer></script>
    <script>
        now = new Date();
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.type = 'text/javascript';
        var script_address = 'https://cdn.yektanet.com/rg_woebegone/scripts/1603/rg.complete.js';
        script.src = script_address + '?v=' + now.getFullYear().toString() + '0'
            + now.getMonth() + '0' + now.getDate() + '0' + now.getHours();
        script.async = true;
        head.appendChild(script);
    </script>
</head>
<body>
<div class = "wrapper site-wrap" id = "site_wrap">
    <div class = "container">
        <div class = "register-form">
            <div class = "register-title">
                <h2>پیش ثبت نام(فقط تهرانی ها)</h2>

                <div class = "sub">
                    <span>دبیرستان غیردولتی پسرانه</span>
                    <span>متوسطه اول و دوم</span>
                </div><!-- .sub -->
                @if($errors->isNotEmpty())
                    <h4 style = "color:red; font-weight: bold">
                        لطفا اطلاعات تمامی قسمت ها را به درستی تکمیل نمایید
                    </h4>
                @endif

            </div><!-- .register-title -->
            @if (Session::has('success'))
                <h2 style = "color:green; font-weight: bold ; text-align: center">
                    {!!   Session::get('success') !!}
                </h2>
            @elseif (Session::has('error'))
                <h2 style = "color:red; font-weight: bold;text-align: center">
                    {!!   Session::pull('error') !!}
                </h2>
            @elseif($eventRegistered)
                <h2 style = "color:darkblue; font-weight: bold;">
                    شما در دبیرستان دانشگاه صنعتی شریف پیش ثبت نام نموده اید
                </h2>
                <h3 style = "color:darkgreen; font-weight: bold;text-align: center; text-decoration: underline">
                    اطلاعات ثبت شده شما:
                </h3>
            @endif

            @if (!Session::pull('success'))
                {!! Form::open(['method'=>'POST' , 'action'=>'Web\SharifSchoolController@registerForSanatiSharifHighSchool']) !!}
                <input name = "firstName" style = "{{ $errors->has('firstName') ? ' border: solid red;' : '' }}" value = "{{(isset($firstName))?$firstName:old('firstName')}}" {{(isset($firstName))?"disabled":""}} type = "text" placeholder = "نام به فارسی">

                <input name = "lastName" style = "{{ $errors->has('lastName') ? ' border: solid red;' : '' }}" value = "{{(isset($lastName))?$lastName:old('lastName')}}" {{(isset($lastName))?"disabled":""}} type = "text" placeholder = "نام خانوادگی به فارسی">

                <input name = "mobile" style = "{{ $errors->has('mobile') ? ' border: solid red;' : '' }}" value = "{{(isset($mobile))?$mobile:old('mobile')}}" {{(isset($mobile))?"disabled":""}} type = "text" placeholder = "شماره موبایل - مثال: 09121234567">

                <input name = "nationalCode" style = "{{ $errors->has('nationalCode') ? ' border: solid red;' : '' }}" value = "{{(isset($nationalCode))?$nationalCode:old('nationalCode')}}" {{(isset($nationalCode))?"disabled":""}} type = "text" placeholder = "کدملی بدون خط تیره">

                <select name = "grade_id" style = "{{ $errors->has('grade_id') ? ' border: solid red;' : '' }}" {{($eventRegistered)?"disabled":""}} class = "nice-select-instance gradeSelect">
                    <option value = "0">انتخاب پایه مورد نظر</option>
                    <option value = "5" @if(isset($grade)) {{($grade==5)?"selected":""}} @else {{(old('grade_id') == 5)?"selected":""}}@endif>
                        هفتم
                    </option>
                    <option value = "6" @if(isset($grade)) {{($grade==6)?"selected":""}} @else {{(old('grade_id') == 6)?"selected":""}}@endif>
                        هشتم
                    </option>
                    <option value = "7" @if(isset($grade)) {{($grade==7)?"selected":""}} @else {{(old('grade_id') == 7)?"selected":""}}@endif>
                        نهم
                    </option>
                    <option value = "1" @if(isset($grade)) {{($grade==1)?"selected":""}} @else {{(old('grade_id') == 1)?"selected":""}}@endif>
                        دهم
                    </option>
                    <option value = "2" @if(isset($grade)) {{($grade==2)?"selected":""}} @else {{(old('grade_id') == 2)?"selected":""}}@endif>
                        یازدهم
                    </option>
                    <option value = "8" @if(isset($grade)) {{($grade==8)?"selected":""}} @else {{(old('grade_id') == 8)?"selected":""}}@endif>
                        دوازدهم
                    </option>
                </select>

                <select name = "major_id" style = "{{ $errors->has('major_id') ? ' border: solid red;' : '' }}" {{($eventRegistered)?"disabled":""}}  class = "nice-select-instance majorSelect">
                    <option value = "0">انتخاب رشته</option>
                    <option value = "1" @if(isset($major)) {{($major==1)?"selected":""}} @else {{(old('major_id') == 1)?"selected":""}}@endif>
                        ریاضی
                    </option>
                    <option value = "2" @if(isset($major)) {{($major==2)?"selected":""}} @else {{(old('major_id') == 2)?"selected":""}}@endif>
                        تجربی
                    </option>
                </select>

                <input name = "score" style = "{{ $errors->has('score') ? ' border: solid red;' : '' }}" value = "{{(isset($score))?$score:old('score')}}" {{($eventRegistered)?"disabled":""}}  type = "text" placeholder = "معدل - مثال: 18.36" maxlength = "5">

                @if(!$eventRegistered)
                    <input type = "submit" value = "ثبت نام">
                @endif
                {!! Form::close() !!}
            @endif

        </div><!-- .register-form -->

    </div><!-- .container -->

</div><!-- #site_wrap -->

<script src = "/acm/extra/schoolRegisterLanding/js/plugins.min.js"></script>
<script>
    jQuery(document).ready(function () {
        jQuery('select.nice-select-instance').niceSelect();
    });
</script>
</body>

</html>
