var InitPage = function() {

    function ajaxSetup() {
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });

    }

    function summernote() {
        $('#descriptionSummerNote').summernote({
            lang: 'fa-IR',
            height: 200,
            popover: {
                image: [],
                link: [],
                air: []
            }
        });
        $('#contextSummerNote').summernote({
            lang: 'fa-IR',
            height: 200,
            popover: {
                image: [],
                link: [],
                air: []
            }
        });
    }

    function persianDatepicker() {
        $("#validSinceDate").persianDatepicker({
            altField: '#validSinceDateAlt',
            altFormat: "YYYY MM DD",
            observer: true,
            format: 'YYYY/MM/DD',
            altFieldFormatter: function(unixDate){
                var d = new Date(unixDate).toISOString();
                return d;
            }
        });
    }

    function inputmask() {
        $("#validSinceTime").inputmask("hh:mm", {
            placeholder: "",
            clearMaskOnLostFocus: true
        });
    }

    function tagsinput() {
        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput({
            tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
        });
    }

    function iterateTagsArray(tagsFromTree) {

        tagsFromTree = tagsFromTree.flat(1);
        var uniqueTagsFromTree = [...new Set(tagsFromTree)];
        var tagsFromTreeLength = uniqueTagsFromTree.length;
        for (var i = 0; i < tagsFromTreeLength; i++) {
            uniqueTagsFromTree[i] = filterTagString(uniqueTagsFromTree[i]);
        }

        var oldTags = $("input.contentTags").tagsinput()[0].itemsArray;
        var oldTagsLength = oldTags.length;
        for (var i = 0; i < oldTagsLength; i++) {
            oldTags[i] = filterTagString(oldTags[i]);
        }

        var newTags = oldTags.concat(uniqueTagsFromTree);
        var uniqueNewTags = [...new Set(newTags)];

        return uniqueNewTags;
    }

    function filterTagString(tagString) {
        tagString = persianJs(tagString).arabicChar().toEnglishNumber().toString();
        tagString = tagString.split(' ').join('_');
        return tagString;
    }

    function initialContentTypeSelect() {
        var selected = $("#rootContentTypes option:selected").text();
        if(selected == "آزمون")
        {
            $("#childContentTypes").prop("disabled" , false);
        }else{
            $("#childContentTypes").prop("disabled" , true);
        }

    }

    function showMetaPreview() {
        SerpsimSimulator.init('.SerpsimSimulatorPortlet .m-portlet__body');
        $(document).trigger('SerpsimSimulator-update', [ $('#name').val(), window.location.href.replace('/edit', ''), $('#descriptionSummerNote').summernote('code')] );
        $(document).on('keyup', '#name, #descriptionSummerNote', function () {
            $(document).trigger('SerpsimSimulator-update', [ $('#name').val(), window.location.href.replace('/edit', ''), $('#descriptionSummerNote').summernote('code')] );
        });
    }

    function showTelegramTemplate() {
        var getVideoNams = function() {
            var videoName = $('#name').val(),
                videoNmes = videoName.split('، '),
                videoName1 = videoNmes[0],
                videoName2 = videoName.replace(videoName1+'، ', '');
            return {
                videoName1: videoName1,
                videoName2: videoName2
            };
        };

        var videoNams = getVideoNams();

        TelegramTemplate.init('content', {
            videoOrder: $('#order').val(),
            setName: contentsetName, // 'کارگاه_نکته_و_تست',
            nameDars: 'nameDars', // 'فیزیک_دهم_کنکور',
            videoName1: videoNams.videoName1,
            videoName2: videoNams.videoName2,
            teacherName: teacherName, // 'پرویز کازرانیان',
            contentUrl: window.location.href.replace('/edit', ''),
            productUrl: 'https://alaatv.com/product/349',
        }, '.TelegramMessagePreviewPortlet .TelegramMessagePreviewTextArea');
    }

    function addEvents() {

        $('#rootContentTypes').on('change', function() {
            initialContentTypeSelect();
        });

        $(document).on("click", ".removeFile", function (){
            var file_id = $(this).data('id');
            var content_id = $(this).data('to');
            $("input[name=file_id]").val(file_id);
            $("input[name=educationalContent_id]").val(content_id);
        });

        $(document).on("click", "#removeFileSubmit", function (){
            var file_id = $("input[name=file_id]").val();
            var content_id = $("input[name=educationalContent_id]").val();
//            toastr.options = {
//                "closeButton": true,
//                "debug": false,
//                "positionClass": "toast-top-center",
//                "onclick": null,
//                "showDuration": "1000",
//                "hideDuration": "1000",
//                "timeOut": "5000",
//                "extendedTimeOut": "1000",
//                "showEasing": "swing",
//                "hideEasing": "linear",
//                "showMethod": "fadeIn",
//                "hideMethod": "fadeOut"
//            };
            $.ajax({
                type: 'POST',
                url: '/detachContentFile/'+content_id+'/'+file_id,
                data:{},
                statusCode: {
                    200: function (response) {
                        location.reload();
                    },
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    422: function (response) {
                        toastr["error"]("خطای ۴۲۲ . خطای ورودی ها", "پیام سیستم");
                    },
                    500: function (response) {
                    },
                    503: function (response) {
                        toastr["error"]("خطای برنامه!", "پیام سیستم");
                    }
                }
            });
        });

        $(document).on("click", ".fileCaptionSubmit", function (){
            var file_id = $(this).attr("id").split("_")[1];
            var content_id = $(this).data("to");
            var caption = $("#caption_"+file_id).val();
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
            $.ajax({
                type: 'POST',
                url: "/storeContentFileCaption"+"/"+content_id+"/"+file_id,
                data:{caption: caption },
                statusCode: {
                    200: function (response) {
                        location.reload();
                    },
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    422: function (response) {
                        toastr["error"]("خطای ۴۲۲ . خطای ورودی ها", "پیام سیستم");
                    },
                    500: function (response) {
                    },
                    503: function (response) {
                        toastr["error"]("خطای برنامه!", "پیام سیستم");
//                    location.reload();
                    },
                    501: function (response) {
                        toastr["warning"](response.responseText, "پیام سیستم");
                    }
                },
            });
        });

        $('form.form-horizontal').submit(function(e) {
            var stringTagsFromTree = $('#tagsString').val();
            var tagsArray = iterateTagsArray(JSON.parse(stringTagsFromTree));
            $("input.contentTags").tagsinput('removeAll');

            var tagsArrayLength = tagsArray.length;
            for (var i = 0; i < tagsArrayLength; i++) {
                $("input.contentTags").tagsinput('add', tagsArray[i]);
            }
        });
    }

    function init() {
        tagsinput();
        ajaxSetup();
        summernote();
        persianDatepicker();
        inputmask();
        addEvents();
        initialContentTypeSelect();
        showTelegramTemplate();
        showMetaPreview();
    }

    return {
        init: init
    };

}();

InitPage.init();
