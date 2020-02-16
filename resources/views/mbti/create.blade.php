@extends('partials.templatePage' , ["pageName" => $pageName])

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/datatables/datatables.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("content")
    <div class = "row">

        <div class = "col-md-12">
            <div class = "portlet light ">
                <div class = "portlet-title tabbable-line">
                    <div class = "caption caption-md">
                        <i class = "icon-globe theme-font hide"></i>
                        <span class = "caption-subject font-blue-madison bold uppercase">@if(strcmp($pageMode , "takeExam") == 0)
                                شرکت در آزمون MBTI @elseif(isset($mbtiAnswer)) مشاهده پاسخنامه
                                MBTI  @if(!isset($mbtiAnswer->user->firstName) && !isset($mbtiAnswer->user->lastName))
                                کاربر
                                ناشناس @else @if(isset($mbtiAnswer->user->firstName)) {{$mbtiAnswer->user->firstName}} @endif @if(isset($mbtiAnswer->user->lastName)) {{$mbtiAnswer->user->lastName}} @endif @endif @endif</span>
                    </div>
                </div>
                <div class = "portlet-body">
                    @if(strcmp($pageMode , "takeExam") == 0)
                        @if($takenExam)
                            <div class = "m-heading-1 border-green m-bordered">
                                <h3>پاسخنامه شما با موفیت درج شده است</h3>
                                <p style = "text-align: justify">کاربر گرامی شما در آزمون شرکت کرده اید و پاسخنامه ی شما با موفقیت درج شده است.</p>
                                <p style = "text-align: justify">پاسخنامه شما توسط کارشناسان تصحیح خواهد شد و نتیجه این ارزیابی در همین صفحه قابل نمایش خواهد بود.</p>
                                <p style = "text-align: justify"> از شکیبایی شما متشکریم</p>
                            </div>
                        @else
                            <div class = "row">
                                <div class = "m-heading-1 border-yellow m-bordered">
                                    <h3>کاربر گرامی توجه کنید</h3>
                                    <p style = "text-align: justify" class = "alert-info">
                                        <strong> برای پی بردن به شخصیت خود، در پاسخ به سؤالات گزینه ای را انتخاب کنید که ویژگیها و شخصیت واقعی شما را توصیف کند و نه ویژگیهایی که می خواهید داشته باشید و یا دیگران از شما توقع دارند.</strong>
                                    </p>
                                    <p style = "text-align: justify">
                                        پاسخ درست یا غلط وجود ندارد. به هیچ وجه گزینه ای را که در مورد شما صدق نمی کند، به این دلیل که فکر می کنید گزینه بهتری است انتخاب نکنید، چون در این صورت نتیجه بدست آمده مغایر با خود واقعی شما خواهد بود. پاسخهای شما فقط بیانگر چگونگی نگرش و نگاه شما به محیط اطراف و چگونگی تصمیم گیری شما در امور مختلف است. بنابراین صادقانه پاسخ دهید تا بتوانید به شخصیت واقعی خود پی ببرید.
                                    </p>
                                    <p style = "text-align: justify">
                                        اگر پاسخ سؤالی را اصلا نمی دانید، یکی را انتخاب کنید. سؤالات طوری طراحی شده که اشتباهات جزئی در نتیجه نهایی در نظر گرفته نمی شود.
                                    </p>
                                </div>
                            </div>
                            <div class = "row margin-top-10">
                                <div class = "col-md-3 "></div>
                                <div class = "col-md-6 alert alert-danger" id = "numberOfQuestionsMessage" style = "text-align: center">
                                    <strong> شما به
                                        <span id = "answeredQuestionsCount"></span>
                                             سؤال از {{Config::get('constants.MBTI_NUMBER_OF_QUESTIONS')}} سؤال پاسخ داده اید
                                    </strong></div>
                            </div>
                            <div class = "row">
                                <div class = "col-md-12 ">
                                    <!-- BEGIN Portlet PORTLET-->
                                    <div class = "portlet box blue-hoki">
                                        <div class = "portlet-title">
                                            <div class = "caption">
                                                <i class = "fa fa-question fa-3x" aria-hidden = "true"></i>
                                                سؤالات آزمون
                                            </div>
                                        </div>
                                        <div class = "portlet-body">
                                            <div class = "scroller" style = "height:500px" data-rail-visible = "1" data-rail-color = "blue" data-handle-color = "#a1b2bd">
                                                {!! Form::open(['method'=>'POST' , 'action'=>'MbtianswerController@store' , 'id'=>'mbtiQuestions']) !!}
                                                <table class = "table table-light table-hover" style = "text-align: center">
                                                    @foreach($questions as $key => $question)
                                                        <tr>
                                                            <td>{{$key}} - {{$question}}
                                                                <div class = "mt-radio-inline">
                                                                    <label class = "mt-radio">
                                                                        <input class = "multiChoice" type = "radio" name = "question{{$key}}" value = "{{(($key-1)*3) + 1}}"/>
                                                                        ابدا اینطور نیستم
                                                                        <span></span>
                                                                    </label>
                                                                    <label class = "mt-radio">
                                                                        <input class = "multiChoice" type = "radio" name = "question{{$key}}" value = "{{(($key-1)*3) + 2}}"/>
                                                                        تا اندازه ای اینطور هستم
                                                                        <span></span>
                                                                    </label>
                                                                    <label class = "mt-radio">
                                                                        <input class = "multiChoice" type = "radio" name = "question{{$key}}" value = "{{(($key++-1)*3) + 3}}"/>
                                                                        کاملا اینطور هستم
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                                <!--end profile-settings-->
                                                {!! Form::close() !!}

                                            </div>
                                            <div class = "margin-top-10" style = "text-align: center">
                                                <button class = "btn red" id = "mbtiSubmit"> ثبت پاسخنامه</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Portlet PORTLET-->
                                </div>
                            </div>
                        @endif
                    @elseif(strcmp($pageMode , "correctExam") == 0)
                        @if(!isset($mbtiAnswer))
                            <div class = "note note-info">
                                <h4 class = "block">مصحح گرامی!</h4>
                                <p>ظاهرا شما گم شده اید! برای دانش آموز مد نظر شما پاسخنامه ای درج نشده است.</p>
                            </div>
                        @else
                            <div class = "row">
                                <div class = "col-md-12">
                                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                    <div class = "portlet light grey">
                                        <div class = "portlet-title">
                                            <div class = "caption font-dark">
                                                <span class = "caption-subject bold uppercase">پاسخنامه</span>
                                            </div>
                                            <div class = "tools"></div>
                                        </div>
                                        <div class = "portlet-body">
                                            <table class = "table table-striped table-bordered table-hover" id = "answers">
                                                <thead>
                                                <tr>
                                                    <th>شماره</th>
                                                    <th> سؤال</th>
                                                    <th> پاسخ</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($questions as $key => $question)
                                                    <tr class = "odd gradeX">
                                                        <td>{{$key}}</td>
                                                        <td>
                                                            {{$question}}
                                                        </td>
                                                        <td>
                                                            @if($answers[$key-1] == (($key-1)*3) + 1)
                                                                ابدا اینطور نیستم
                                                            @elseif($answers[$key-1] == (($key-1)*3) + 2)
                                                                تا اندازه ای اینطور هستم
                                                            @elseif($answers[$key-1] == (($key-1)*3) + 3)
                                                                کاملا اینطور هستم
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- END EXAMPLE TABLE PORTLET-->
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-toastr/toastr.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/scripts/datatable.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/datatables/datatables.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/ui-toastr.min.js" type = "text/javascript"></script>
    {{--<script src="/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>--}}
    <script type = "text/javascript" src = "/js/extraJS/scripts/admin-makeDataTable.js"></script>
@endsection

@section("extraJS")
    <script type = "text/javascript" src = "/js/extraJS/js-cookie/js.cookie.js"></script>
    <script type = "text/javascript">
        //            console.log(Cookies.getJSON("choices"));
        var onCompeletionMessage = "شما به تمام سؤالات پاسخ داده اید ، برای ارسال بر روی دکمه ثبت در کلیک نمایید";
        var choices = [];
        if (Cookies.get("choices") == null) {
            Cookies.set("choices", choices);
        } else {
            choices = Cookies.getJSON("choices");
        }
        //          console.log(choices);

        if (choices.length > 0) {
            $.each(choices, function (index, value) {
                $("input[name=" + $("input[value=" + value + "]").attr("name") + "][value=" + value + "]").attr('checked', 'checked');
            });
        }
        if (choices.length == {{Config::get('constants.MBTI_NUMBER_OF_QUESTIONS')}}) {
            $("#numberOfQuestionsMessage").removeClass("alert-danger");
            $("#numberOfQuestionsMessage").addClass("alert-success");
            $("#numberOfQuestionsMessage > strong").html(onCompeletionMessage);
        } else $("#answeredQuestionsCount").html(choices.length);

        $(document).on("change", ".multiChoice", function () {
            var choice_id = $(this).val();
            var similarIndex;
            if (choice_id % 3 == 1) {
                similarIndex = $.inArray(parseInt(choice_id) + 1, choices);
                if (similarIndex >= 0) choices.splice(similarIndex, 1);
                similarIndex = $.inArray(parseInt(choice_id) + 2, choices);
                if (similarIndex >= 0) choices.splice(similarIndex, 1);
                choices.push(parseInt(choice_id));

            } else if (choice_id % 3 == 2) {
                similarIndex = $.inArray(parseInt(choice_id) - 1, choices);
                if (similarIndex >= 0) choices.splice(similarIndex, 1);
                similarIndex = $.inArray(parseInt(choice_id) + 1, choices);
                if (similarIndex >= 0) choices.splice(similarIndex, 1);
                choices.push(parseInt(choice_id));
            } else if (choice_id % 3 == 0) {
                similarIndex = $.inArray(parseInt(choice_id) - 1, choices);
                if (similarIndex >= 0) choices.splice(similarIndex, 1);
                similarIndex = $.inArray(parseInt(choice_id) - 2, choices);
                if (similarIndex >= 0) choices.splice(similarIndex, 1);
                choices.push(parseInt(choice_id));
            }

            if (choices.length == {{Config::get('constants.MBTI_NUMBER_OF_QUESTIONS')}}) {
                $("#numberOfQuestionsMessage").removeClass("alert-danger");
                $("#numberOfQuestionsMessage").addClass("alert-success");
                $("#numberOfQuestionsMessage > strong").html(onCompeletionMessage);
            } else $("#answeredQuestionsCount").html(choices.length);
            Cookies.set("choices", choices);
//            console.log(Cookies.getJSON("choices"));

        });
        $(document).on("click", "#mbtiSubmit", function () {
            if (choices.length < {{Config::get('constants.MBTI_NUMBER_OF_QUESTIONS')}} ) {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-top-center",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr["warning"]("لطفا به تمام سؤالات پاسخ دهید", "کاربر گرامی");
            } else {
                var formData = new FormData($("#mbtiQuestions")[0]);
                $.ajax({
                    type: "POST",
                    url: $("#mbtiQuestions").attr("action"),
                    data: formData,
                    statusCode: {
                        //The status for when action was successful
                        200: function (response) {
                            location.reload();
//                             console.log(response);
//                             console.log(response.responseText);
                        },
                        //The status for when the user is not authorized for making the request
                        403: function (response) {
                            window.location.replace("/403");
                        },
                        404: function (response) {
                            window.location.replace("/404");
                        },
                        //The status for when form data is not valid
                        422: function (response) {
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "positionClass": "toast-top-center",
                                "onclick": null,
                                "showDuration": "1000",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };
                            toastr["error"]("شما باید به تمام سؤالات پاسخ دهید", "خطای ورودی ها!");
                        },
                        //The status for when there is error php code
                        500: function (response) {
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "positionClass": "toast-top-center",
                                "onclick": null,
                                "showDuration": "1000",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };
                            toastr["error"]("خطای برنامه!", "پیام سیستم");
                        },
                        //The status for when there is error php code
                        503: function (response) {
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "positionClass": "toast-top-center",
                                "onclick": null,
                                "showDuration": "1000",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };
                            toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                        }
                    },
                    contentType: false,
                    processData: false
                });
            }
        });
        makeButtonDataTable("answers");
    </script>
@endsection
