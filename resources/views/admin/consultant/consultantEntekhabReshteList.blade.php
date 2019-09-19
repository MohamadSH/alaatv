@extends("app")

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/jquery-nestable/jquery.nestable.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
@endsection

@section("title")
    <title>آلاء|پنل مشاور - انتخاب رشته</title>
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
                <span>لیست انتخاب رشته </span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-12">
            <div class = "portlet  light ">
                <div class = "portlet-title">
                    <div class = "caption">
                        <i class = "fa fa-list-alt font-purple"></i>
                        <span class = "caption-subject font-purple sbold uppercase">لیست دانش آموزان</span>
                        <input type = "hidden" value = "1" name = "parentMajor">
                    </div>
                    {{--<div class="actions">--}}
                    {{--<div class="btn-group btn-group-devided" data-toggle="buttons">--}}
                    {{--<label class="btn btn-transparent grey-salsa btn-circle btn-sm active">--}}
                    {{--<input type="radio" name="options" class="toggle" id="option1">New</label>--}}
                    {{--<label class="btn btn-transparent grey-salsa btn-circle btn-sm">--}}
                    {{--<input type="radio" name="options" class="toggle" id="option2">Returning</label>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                </div>
                <div class = "portlet-body">

                    <div class = "table-scrollable">
                        <table class = "table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th class = "text-center">
                                    <i class = "icon-user"></i>
                                    نام دانش آموز
                                </th>
                                <th class = "text-center">
                                    <i class = "fa fa-graduation-cap"></i>
                                    رشته
                                </th>
                                <th class = "text-center">
                                    <i class = "fa "></i>
                                    عملیات
                                </th>
                            </tr>
                            </thead>
                            <tbody class = "text-center">
                            @include("usersurveyanswers.index")
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/jquery-nestable/jquery.nestable-rtl.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-toastr/toastr.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/ui-toastr.min.js" type = "text/javascript"></script>
    {{--<script src="/assets/pages/scripts/ui-nestable.min.js" type="text/javascript"></script>--}}
    <script>
        var UINestable = function () {

            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };


            return {
                //main function to initiate the module
                init: function () {

                    // output initial serialised data
//                updateOutput($('#nestable_list_1').data('output', $('#nestable_list_1_output')));
//                updateOutput($('#nestable_list_2').data('output', $('#nestable_list_2_output')));

                    $('#nestable_list_menu').on('click', function (e) {
                        var target = $(e.target),
                            action = target.data('action');
                        if (action === 'expand-all') {
                            $('.dd').nestable('expandAll');
                        }
                        if (action === 'collapse-all') {
                            $('.dd').nestable('collapseAll');
                        }
                    });

                    $('#nestable_list_3').nestable({
                        maxDepth: 1,
                    });

                }

            };

        }();

        jQuery(document).ready(function () {
            UINestable.init();
        });

        var dataId;
        var previousDataId;
        var nextDataId;
        $('.dd3-handle').on('mousedown', function () {
            dataId = parseInt($(this).parent().attr("data-id"));
            var previousSiblings = $("#dd-item_" + dataId).closest(".dd-item").prev();
            previousDataId = parseInt(previousSiblings.attr("data-id"));
            if (isNaN(previousDataId)) {
                previousDataId = 0;
            }
            var nextSibling = $("#dd-item_" + dataId).closest(".dd-item").next();
            nextDataId = parseInt(nextSibling.attr("data-id"));
            if (isNaN(nextDataId)) {
                nextDataId = 0;
            }
        });
        $('.dd').on('change', function () {
            var draggedItem = $("#dd-item_" + dataId);
            var previousSiblings = $("#dd-item_" + dataId).closest(".dd-item").prev();
            var caption = parseInt(previousSiblings.find(".dd-item-caption").html());
            var nextSiblings = $("#dd-item_" + dataId).closest(".dd-item").next();

            var newNextDataId;
            if (isNaN(parseInt(nextSiblings.attr("data-id")))) newNextDataId = 0;
            else newNextDataId = parseInt(nextSiblings.attr("data-id"));

            var newPreviousDataId;
            if (isNaN(parseInt(previousSiblings.attr("data-id")))) newPreviousDataId = 0;
            else newPreviousDataId = parseInt(previousSiblings.attr("data-id"));

            if (previousDataId === newPreviousDataId && nextDataId === newNextDataId) return true;

            if (isNaN(caption)) {

                if (previousDataId === 0 && nextDataId === newNextDataId) return true;
                var nextCaption = parseInt(nextSiblings.find(".dd-item-caption").html());
                previousSiblings = $("#dd-item_" + (nextCaption - 1));
                caption = parseInt(previousSiblings.find(".dd-item-caption").html());
            }

            if (caption > dataId) {//moved down
                draggedItem.attr("id", "dd-item_");
                var captionCounter = parseInt(draggedItem.find(".dd-item-caption").html());
                var siblingCounter = $("#dd-item_" + (captionCounter + 1));
                while (captionCounter < caption) {

                    siblingCounter.find(".dd-item-caption").html(captionCounter);
                    siblingCounter.attr("id", "dd-item_" + captionCounter);
                    siblingCounter.attr("data-id", captionCounter);
                    siblingCounter.find(".majorCode").attr("id", "majorCode_" + captionCounter);
                    siblingCounter.find(".majorName").attr("id", "majorName_" + captionCounter);
                    captionCounter = captionCounter + 1;
                    siblingCounter = $("#dd-item_" + (captionCounter + 1));
                }
                draggedItem.find(".dd-item-caption").html(caption);
                draggedItem.attr("id", "dd-item_" + caption);
                draggedItem.attr("data-id", caption);
                draggedItem.find(".majorCode").attr("id", "majorCode_" + caption);
                draggedItem.find(".majorName").attr("id", "majorName_" + caption);
            } else {//moved up
                caption = parseInt(nextSiblings.find(".dd-item-caption").html());

                draggedItem.attr("id", "dd-item_");
                var captionCounter = parseInt(draggedItem.find(".dd-item-caption").html());
                var siblingCounter = $("#dd-item_" + (captionCounter - 1));
                while (captionCounter > caption) {

                    siblingCounter.find(".dd-item-caption").html(captionCounter);
                    siblingCounter.attr("id", "dd-item_" + captionCounter);
                    siblingCounter.attr("data-id", captionCounter);
                    siblingCounter.find(".majorCode").attr("id", "majorCode_" + captionCounter);
                    siblingCounter.find(".majorName").attr("id", "majorName_" + captionCounter);
                    captionCounter = captionCounter - 1;
                    siblingCounter = $("#dd-item_" + (captionCounter - 1));
                }
                draggedItem.find(".dd-item-caption").html(caption);
                draggedItem.attr("id", "dd-item_" + caption);
                draggedItem.attr("data-id", caption);
                draggedItem.find(".majorCode").attr("id", "majorCode_" + caption);
                draggedItem.find(".majorName").attr("id", "majorName_" + caption);
            }

        });
    </script>
@endsection

@section("extraJS")
    <script>
        var insertedMajorCodes = [];
        $(document).on("focusout", ".majorCode", function () {
            var majorCode = $(this).val();
            var textId = $(this).attr("id").split("majorCode_")[1];
            var parentMajorId = $("input[name=parentMajor]").val();
            majorCode = $.trim(majorCode);

            if (majorCode.length > 0)
                if ($.inArray(parseInt(majorCode), insertedMajorCodes) == -1)
                    $.ajax({
                        type: "GET",
                        url: "{{action("Web\MajorController@index")}}",
                        data: {majorCode: [majorCode], majorParent: parentMajorId},
                        statusCode: {
                            //The status for when action was successful
                            200: function (response) {
                                //                    console.log(response) ;
                                //                    console.log(response.responseText) ;
                                if (response.length != 0) {
                                    $("#majorName_" + textId).val(response[0].name);
                                    insertedMajorCodes.push(parseInt(majorCode));
                                } else {
                                    $("#majorCode_" + textId).val("");
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
                                    toastr["error"]("رشته ای با این کد وجود ندارد", "پیام سیستم");
                                }
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
                else {
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
                    toastr["warning"]("این رشته در لیست وجود دارد", "پیام سیستم");
                }

            return false;
        });

    </script>
@endsection

