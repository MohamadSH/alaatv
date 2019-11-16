<!DOCTYPE html>
<html>
<head>
    <meta charset = "utf-8">
    <title>درخت مباحث آلاء</title>
    <meta name = "viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name = "csrf-token" content = "{{ csrf_token() }}"/>
{{--    <link rel = "stylesheet" href = "/acm/extra/topicsTree/css/bootstrap.min.css">--}}
{{--    <link rel = "stylesheet" href = "/acm/extra/topicsTree/jsTree/dist/themes/default/style.min.css"/>--}}
    <style>
        *, body {
            direction: rtl;
            text-align: right;
        }
        
        #loadingHtml {
            display: block;
        }
        
        #html {
            display: none;
        }
        
        .no_checkbox {
            position: relative;
        }
        
        .no_checkbox > i.jstree-icon.jstree-ocl {
            position: absolute;
            right: 0px;
            width: 100%;
            background: transparent;
            z-index: 999;
        }
        
        .no_checkbox > a i.jstree-checkbox {
            display: none;
        }
        
        .hidden {
            display: none;
        }
        
        .customHidden {
            position: absolute;
            top: 0px;
            right: 25px;
            z-index: -2;
        }
        
        li[data-has-new="1"] > a {
            color: #00d1ea !important;
            font-weight: bold;
        }
        
        li[data-is-new="1"] > a {
            color: #00ea00 !important;
            font-weight: bold;
        }
        
        li[data-is-new="1"] {
            color: #03a800 !important;
            font-weight: bold;
        }
        
        
        .objectBody {
            margin-left: 20px;
        }
        
        .inChildren {
            margin-left: 20px;
        }
        
        #convertedAlaaNodeArrayToStringFormat,
        #convertedAlaaNodeArrayToStringFormat * {
            direction: ltr;
            text-align: left;
        }
        .btnIgnoreUpdateItem {
            position: relative;
            z-index: 9999;
            padding: 2px 5px;
            line-height: 15px;
            margin-right: 45px;
        }
    </style>
    
{{--    <script src='https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.4.4/lottie.min.js'></script>--}}
{{--    <script src='https://cdnjs.cloudflare.com/ajax/libs/bodymovin/4.13.0/bodymovin.min.js'></script>--}}
</head>
<body>


<video style="width: 100%;" autoplay loop muted playsinline>
{{--    <source src="/acm/loader.webm" type="video/webm">--}}
    <source src="/acm/loader.mp4" type="video/mp4">
</video>


<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<lottie-player
        src="/acm/data.json"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop controls autoplay >
</lottie-player>

<div id="svgContainer"></div>


<div class = "container-fluid">
    <div class = "row">
        <div class = "col">
            <div class = "card text-center">
                <div class = "card-header text-center">
                    لیست موضوعات
                </div>
                <div class = "card-body">
                    <div id = "loadingHtml">
                        <div style = "height: 300px; overflow: hidden;">
                            <img src = "/acm/extra/topicsTree/img/loading.gif" style = "margin-top: -150px;"/>
                        </div>
                    </div>
                    <div id = "html" class = "demo treeView">
                        @if(isset($htmlPrint))
                            {!! $htmlPrint !!}
                        @endif
                    </div>
                </div>
                <div class = "card-footer text-muted">
                    مجموعه آموزشی آلاء
                </div>
            </div>
        </div>
    </div>
</div>

{{--<script type = "text/javascript" src = "/acm/extra/topicsTree/jquery-3.3.1.min.js"></script>--}}
{{--<script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity = "sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin = "anonymous"></script>--}}
{{--<script src = "/acm/extra/topicsTree/js/bootstrap.min.js"></script>--}}
{{--<script type = "text/javascript" src = "/acm/extra/topicsTree/jsTree/dist/jstree.min.js"></script>--}}
{{--<script type = "text/javascript" src = "/acm/extra/topicsTree/main.js"></script>--}}
{{--<script type = "text/javascript">--}}
{{--    $.ajaxSetup({--}}
{{--        headers: {--}}
{{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}

{{--<script type="text/javascript">--}}
{{--    var svgContainer = document.getElementById('svgContainer');--}}

{{--    var animItem = bodymovin.loadAnimation({--}}
{{--        wrapper: svgContainer,--}}
{{--        animType: 'svg',--}}
{{--        loop: true,--}}
{{--        path: '/acm/data.json'--}}
{{--        // path: 'https://labs.nearpod.com/bodymovin/demo/markus/isometric/markus2.json'--}}
{{--    });--}}
{{--</script>--}}

<script type = "text/javascript">


{{--    var treePathData = {!! json_encode($treePathData) !!};--}}

{{--    $(document).ready(function () {--}}
{{--        $('#html')--}}
{{--        // listen for event--}}
{{--            .on('changed.jstree', function (e, data) {--}}
{{--                if ($(data.event.target).hasClass('btnIgnoreUpdateItem')) {--}}
{{--                    return;--}}
{{--                }--}}
{{--                updateSelectedItems()--}}

{{--                // var i, j, r = [];--}}
{{--                // for(i = 0, j = data.selected.length; i < j; i++) {--}}
{{--                //     r.push(data.instance.get_node(data.selected[i]).text);--}}
{{--                // }--}}
{{--                // $('#event_result').html('Selected: ' + r.join(', '));--}}
{{--            })--}}
{{--            .on('loaded.jstree', function (e, data) {--}}
{{--                updateSelectedItems();--}}
{{--                $('#loadingHtml').fadeOut();--}}
{{--                $('#html').fadeIn();--}}
{{--            })--}}
{{--            // create the instance--}}
{{--            .jstree({--}}
{{--                "core": {--}}
{{--                    "themes": {--}}
{{--                        // "name" : "dark",--}}
{{--                        // "variant" : "large",--}}
{{--                        // "theme" : "dark",--}}
{{--                        // "dots" : true,--}}
{{--                        // "icons" : false--}}
{{--                    }--}}
{{--                },--}}
{{--                "checkbox": {--}}
{{--                    "keep_selected_style": false--}}
{{--                },--}}
{{--                "plugins": ["checkbox"]--}}
{{--            });--}}

{{--        $(document).on('click', 'li[data-is-new="1"] > i, li[data-is-new="1"] > a', function (e, data) {--}}
{{--            let lnid = $(this).parents('li').attr('data-alaa-node-id');--}}
{{--            lnid = lnid.split('-');--}}
{{--            lnid = lnid[1];--}}
{{--            $.ajax({--}}
{{--                type: 'GET',--}}
{{--                url: '/tree/getArrayString/' + lnid,--}}
{{--                data: {},--}}
{{--                success: function (result) {--}}
{{--                    $('#convertedAlaaNodeArrayToStringFormat').html(result);--}}
{{--                    result = result.toString();--}}
{{--                    result = result.replace(/<div>/g, '')--}}
{{--                        .replace(/<\/div>/g, '')--}}
{{--                        .replace(/<div class='objectBody'>/g, '')--}}
{{--                        .replace(/<div class='objectWraper'>/g, '')--}}
{{--                        .replace(/<div class='inChildren'>/g, '');--}}
{{--                    $('#selectedConvertedAlaaNodeArrayToStringFormat').val(result);--}}
{{--                },--}}
{{--                error: function (result) {--}}
{{--                }--}}
{{--            });--}}

{{--        });--}}

{{--        $(document).on('click', '.btnIgnoreUpdateItem', function (e, data) {--}}
{{--            let iuid = $(this).data('ignore');--}}
{{--            if (confirm('آیا از نادیده گرفتن این آیتم از آپدیت اطمینان دارید؟')) {--}}
{{--                $.ajax({--}}
{{--                    type: 'GET',--}}
{{--                    url: '/tree/ignoreUpdateItem/' + iuid,--}}
{{--                    data: {},--}}
{{--                    success: function (result) {--}}
{{--                        window.location.reload();--}}
{{--                    },--}}
{{--                    error: function (result) {--}}
{{--                        window.location.reload();--}}
{{--                    }--}}
{{--                });--}}
{{--            } else {--}}
{{--            }--}}
{{--        });--}}

{{--    });--}}

</script>
</body>
</html>