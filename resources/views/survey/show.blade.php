@extends("app")

@section("metadata")
    <meta name = "_token" content = "{{ csrf_token() }}">
@endsection

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
    <link href = "/assets/pages/css/about-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection
@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{route('web.index')}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <i class = "icon-user"></i>
                <a href = "{{action("Web\SurveyController@show")}}">فرم سؤالات</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>فرم {{$survey->name}}</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-12">
            <div class = "portlet box blue">
                {{--<div class="portlet-title">--}}
                {{--<div class="caption">--}}
                {{--<i class="fa fa-graduation-cap" aria-hidden="true"></i>فرم اطلاعات انتخاب رشته </div>--}}
                {{--<div class="tools">--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class = "portlet-body">
                    <div class = "row margin-top-20">
                        <div class = "col-md-12">
                            <div class = "nav-justified">
                                <ul class = "nav nav-tabs nav-justified">
                                    @foreach($questions as $key => $question)
                                        <li @if($key == 0) class = "active" @endif>
                                            <a href = "#tab_1_1_{{$key+1}}" data-toggle = "tab"> {{$question->title}} </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class = "tab-content">
                                    @foreach($questions as $key => $question)
                                        <div class = "tab-pane @if($key == 0) active @endif" id = "tab_1_1_{{$key+1}}">
                                            @if(strcmp($question->control->name, "multiSelect") == 0)
                                                <div class = "col-md-12 margin-top-20">
                                                    <p>{{$question->statement}}</p>
                                                    <p class = "m--font-info" style = "text-align: justify">{{$question->description}}</p>
                                                    <select class = "mt-multiselect btn btn-default" multiple = "multiple" data-label = "left" data-width = "100%" data-filter = "true" data-action-onchange = "true" id = "question_{{$question->id}}">
                                                        @foreach($questionsData[$question->id] as $key => $items)
                                                            <optgroup label = "{{$key}}" class = "group-{{$key}}">
                                                                @foreach($items as $key2 => $item)
                                                                    <option value = "{{$key2}}" @if(array_key_exists($key2 , $answersData[$question->id])) selected = "selected" @endif >{{$item}}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                            <div class = "col-md-12">
                                                <div class = "table-scrollable">
                                                    <table class = "table table-bordered table-hover" id = "answerTable_{{$question->id}}">
                                                        <thead>
                                                        <tr>
                                                            <th class = "text-center"> ثبت شده ها:
                                                                <span id = "answerTableHeaderCounterNumber_{{$question->id}}">{{count($answersData[$question->id])}}</span>
                                                                <img class = "hidden" id = "answerTableHeaderCounterLoading_{{$question->id}}" src = "/assets/layouts/layout2/img/loading-spinner-blue.gif" style = "height: 25px">
                                                            </th>
                                                            {{--<th class="text-center">دلیل انتخاب</th>--}}
                                                        </tr>
                                                        </thead>
                                                        <tbody class = "text-center">
                                                        @if(empty($answersData[$question->id]))
                                                            <tr class = "text-center bold m--font-danger">
                                                                <td colspan = "2">شما تاکنون موردی را درج ننموده اید</td>
                                                            </tr>
                                                        @else
                                                            @foreach($answersData[$question->id] as $item)
                                                                <tr>
                                                                    <td>
                                                                        {{$item}}
                                                                    </td>
                                                                    {{--<td>--}}
                                                                    {{--<div class="input-group">--}}
                                                                    {{--<input class="form-control" type="text" name="" placeholder="لطفا دلیل انتخاب خود را بنویسید">--}}
                                                                    {{--<span class="input-group-addon">--}}
                                                                    {{--<i class="fa fa-pencil"></i>--}}
                                                                    {{--<img class="hidden" src="/assets/layouts/layout2/img/loading-spinner-blue.gif" style="height:70%;">--}}
                                                                    {{--<img class="hidden" src="/assets/layouts/layout2/img/loading-spinner-blue.gif" style="height:70%;">--}}
                                                                    {{--</span>--}}
                                                                    {{--</div>--}}
                                                                    {{--</td>--}}
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/js/extraJS/scripts/showSurvey.js" type = "text/javascript"></script>
    {{--<script src="/assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>--}}

@endsection

@section("footerPageLevelScript")
    {{--<script src="/assets/pages/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>--}}
@endsection

@section("extraJS")
    <script>
        /**
         * Set token for ajax request
         */
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                }
            });
        });

        var ComponentsBootstrapMultiselect = function () {

            return {
                //main function to initiate the module
                init: function () {
                    $('.mt-multiselect').each(function () {
                        var btn_class = $(this).attr('class');
                        var clickable_groups = ($(this).data('clickable-groups')) ? $(this).data('clickable-groups') : false;
                        var collapse_groups = ($(this).data('collapse-groups')) ? $(this).data('collapse-groups') : false;
                        var drop_right = ($(this).data('drop-right')) ? $(this).data('drop-right') : false;
                        var drop_up = ($(this).data('drop-up')) ? $(this).data('drop-up') : false;
                        var select_all = ($(this).data('select-all')) ? $(this).data('select-all') : false;
                        var width = ($(this).data('width')) ? $(this).data('width') : '';
                        var height = ($(this).data('height')) ? $(this).data('height') : '';
                        var filter = ($(this).data('filter')) ? $(this).data('filter') : false;

                        // advanced functions
                        var onchange_function = function (option, checked, select) {
//                            alert('Changed option ' + $(option).val() + '.');
                            var parentSelect = $(option).parent().closest('select');
                            var question_id = parentSelect.attr("id").split("question_")[1];
                            var answer = parentSelect.val();
                            $.ajax({
                                type: "POST",
                                url: "{{action('UserSurveyAnswerController@store')}}",
                                data: {
                                    event_id:{{$event->id}} ,
                                    survey_id:{{$survey->id}} ,
                                    question_id: question_id,
                                    answer: answer
                                },
                                statusCode: {
                                    //The status for when action was successful
                                    200: function (response) {
//                                         console.log(response);
//                                         console.log(response.responseText);
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
                                    },
                                    //The status for when there is error php code
                                    500: function (response) {
//                                        console.log(response);
//                                        console.log(response.responseText);
                                    },
                                    //The status for when there is error php code
                                    503: function (response) {
                                    }
                                }
                            });
                            $("#answerTableHeaderCounterLoading_" + question_id).removeClass("hidden");
                            $("#answerTableHeaderCounterNumber_" + question_id).addClass("hidden");
                            $.ajax({
                                type: "GET",
                                url: "{{action('UserSurveyAnswerController@index')}}",
                                data: {
                                    event_id: [{{$event->id}}],
                                    survey_id: [{{$survey->id}}],
                                    question_id: [question_id]
                                },
                                statusCode: {
                                    //The status for when action was successful
                                    200: function (response) {
                                        var querySourceUrl;
                                        var answers;
                                        var question_id;
                                        var answersCount;
                                        $.each(response, function (key, value) {
                                            querySourceUrl = value.questionQuerySourceUrl;
                                            answers = $.parseJSON(value.userAnswer.answer);
                                            answersCount = answers.length;
                                            question_id = value.userAnswer.question_id;
                                            var answerTableBody = "";
                                            $.ajax({
                                                type: "GET",
                                                url: querySourceUrl,
                                                data: {ids: answers},
                                                statusCode: {
                                                    //The status for when action was successful
                                                    200: function (response) {
                                                        $.each(response, function (key, value) {
                                                            answerTableBody = answerTableBody + "<tr><td>" + value.name + "</td></tr>";
                                                        });
                                                        $("#answerTable_" + question_id + " > tbody").html(answerTableBody);
                                                        $("#answerTableHeaderCounterLoading_" + question_id).addClass("hidden");
                                                        $("#answerTableHeaderCounterNumber_" + question_id).html(answersCount);
                                                        $("#answerTableHeaderCounterNumber_" + question_id).removeClass("hidden");
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
                                                    },
                                                    //The status for when there is error php code
                                                    500: function (response) {
//                                        console.log(response);
//                                         console.log(response.responseText);
                                                    },
                                                    //The status for when there is error php code
                                                    503: function (response) {
                                                    }
                                                }
                                            });
                                        });
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
                                    },
                                    //The status for when there is error php code
                                    500: function (response) {
//                                        console.log(response);
//                                         console.log(response.responseText);
                                    },
                                    //The status for when there is error php code
                                    503: function (response) {
                                    }
                                }
                            });
                        };
                        var dropdownshow_function = function (event) {
                            alert('Dropdown shown.');
                        };
                        var dropdownhide_function = function (event) {
                            alert('Dropdown Hidden.');
                        };

                        // init advanced functions
                        var onchange = ($(this).data('action-onchange') == true) ? onchange_function : '';
                        var dropdownshow = ($(this).data('action-dropdownshow') == true) ? dropdownshow_function : '';
                        var dropdownhide = ($(this).data('action-dropdownhide') == true) ? dropdownhide_function : '';

                        // template functions
                        // init variables
                        var li_template;
                        if ($(this).attr('multiple')) {
                            li_template = '<li class="mt-checkbox-list"><a href="javascript:void(0);"><label class="mt-checkbox"> <span></span></label></a></li>';
                        } else {
                            li_template = '<li><a href="javascript:void(0);"><label></label></a></li>';
                        }

                        // init multiselect
                        $(this).multiselect({
                            enableClickableOptGroups: clickable_groups,
                            enableCollapsibleOptGroups: collapse_groups,
                            disableIfEmpty: true,
                            enableFiltering: filter,
                            includeSelectAllOption: select_all,
                            dropRight: drop_right,
                            buttonWidth: width,
                            maxHeight: height,
                            onChange: onchange,
                            onDropdownShow: dropdownshow,
                            onDropdownHide: dropdownhide,
                            buttonClass: btn_class,
                            //optionClass: function(element) { return "mt-checkbox"; },
                            //optionLabel: function(element) { console.log(element); return $(element).html() + '<span></span>'; },
                            /*templates: {
                                li: li_template,
                            }*/
                        });
                    });

                }
            };

        }();

        jQuery(document).ready(function () {
            ComponentsBootstrapMultiselect.init();

            var grants = [
                {id: "p_1", location: "loc_1", type: "A", funds: "5000"},
                {id: "p_2", location: "loc_2", type: "B", funds: "2000"},
                {id: "p_3", location: "loc_3", type: "C", funds: "500"},
                {id: "p_2", location: "_ibid", type: "D", funds: "1000"},
                {id: "p_2", location: "_ibid", type: "E", funds: "3000"}
            ];
            var joined = [];

// map and push to joined
            grants.map(
                function (v) {
                    if (!(v.id in this)) {
                        this[v.id] = v;
                        joined.push(v);
                    } else {
                        var current = this[v.id];
                        current.type = [v.type].concat(current.type);
                        current.funds = [v.funds].concat(current.funds);
                    }
                }, {}
            );

            console.log(JSON.stringify(joined, null, ' '));
        });
    </script>
@endsection

