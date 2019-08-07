@permission((Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS')))
@extends("app",["pageName"=>"admin"])

@section('page-css')
    <link href = "{{ mix('/css/admin-content-create.css') }}" rel = "stylesheet" type = "text/css"/>
    {{--<link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>--}}
    <style>
        .datepicker-header {
            direction: ltr;
        }

        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: #fff;
            background: #36a3f7;
            padding: 2px 5px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
@endsection

@section('pageBar')

    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item">
                <a class = "m-link" href = "{{action("Web\AdminController@adminContent")}}">مدیریت محتوا</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">درج محتوای آموزشی</a>
            </li>
        </ol>
    </nav>

@endsection

@section('content')
    @include("systemMessage.flash")
    <div class = "row" style = "margin-bottom: 10px">
        <div class = "col-md-12">
            <form id = "my-awesome-dropzone" class = "dropzone dropzone-file-area needsclick dz-clickable">
                {{--{{ csrf_field() }}--}}
                {{--<div class="row">--}}
                {{--<div class="col-md-2">--}}
                {{--                        {!! Form::select(null, $grades , null, ['class' => 'form-control', 'id' => 'grades' , 'placeholder' => 'انتخاب مقطع'  ]) !!}--}}
                {{--<select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200"--}}
                {{--id="grades" name="grades[]" title="انتخاب مقطع">--}}
                {{--@foreach($grades as $key=>$value)--}}
                {{--<option value="{{$key}}">{{$value}}</option>--}}
                {{--@endforeach--}}
                {{--</select>--}}
                {{--</div>--}}
                {{--<div class="col-md-2">--}}
                {{--                        {!! Form::select(null, $majors , null, ['class' => 'form-control', 'id' => 'majors' , 'placeholder' => 'انتخاب رشته'  ]) !!}--}}
                {{--<select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200"--}}
                {{--id="majors" name="majors[]" title="انتخاب رشته">--}}
                {{--@foreach($majors as $key=>$value)--}}
                {{--<option value="{{$key}}">{{$value}}</option>--}}
                {{--@endforeach--}}
                {{--</select>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class = "row">
                    <div class = "col-md-6">
                        <select name = "contenttype" class = "form-control m-input m-input--air" id = "rootContentTypes">
                            <option value = "" selected>انتخاب نوع محتوا</option>
                            @foreach($rootContentTypes as $rootContentType)
                                <option value = "{{$rootContentType->id}}" data-title = "{{$rootContentType->name}}">{{$rootContentType->displayName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-md-6">
                        {!! Form::select('contentset', $contentsets , null, ['class' => 'form-control m-input m-input--air', 'id' => 'contentSets' , 'placeholder' => 'انتخاب پلی لیست'  ]) !!}
                    </div>
                    <div class = "col-md-6">
                        {!! Form::select('author', $authors , null, ['class' => 'form-control m-input m-input--air', 'id' => 'authors' , 'placeholder' => 'انتخاب دبیر'  ]) !!}
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-md-12">
                        <div class = "fallback">
                            <input name = "file" type = "file" multiple/>
                        </div>
                        <div class = "dropzone-previews"></div>
                        <div class = "dz-message needsclick">
                            <h4 class = "sbold ">
                                فایل خود را اینجا بیندازید و یا بر روی این قسمت کلیک کنید
                            </h4>
                            <span class = "m-badge m-badge--info m-badge--wide m-badge--rounded">توجه:</span>
                            فرمت مجاز
                            <label class = "m--font-danger">pdf,rar</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12" id = "messageDiv"></div>
    </div>
    <div class = "row">
        <div id = "dropzone-elements" class = "col dropzone dropzone-previews" style = "background: none; border:none"></div>
    </div>
@endsection

@section('page-js11')
    {{--<script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>--}}
    {{--<script src="/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>--}}
    {{--<script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>--}}
    {{--<script src="/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>--}}


    {{--<script src="/assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>--}}


    {{--<script src="/assets/global/plugins/dropzone/dropzone.js" type="text/javascript"></script>--}}
    {{--<script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>--}}
    {{--<script src="/assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>--}}
    {{--<script src="/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>--}}


    {{--<script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>--}}


    {{--<script src="/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>--}}
@endsection

@section("footerPageLevelScript111")
    <script src = "/assets/pages/scripts/components-editors.min.js" type = "text/javascript"></script>
    {{--<script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>--}}
    <script src = "/assets/pages/scripts/form-input-mask.min.js" type = "text/javascript"></script>
    {{--<script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>--}}
    <script src = "/assets/pages/scripts/form-icheck.min.js" type = "text/javascript"></script>
    {{--<script src="/assets/pages/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>--}}
@endsection

@section('page-js')
    <script src = "{{ mix('/js/admin-content-create.js') }}"></script>
    {{--<script src="/js/extraJS/scripts/admin-makeMultiSelect.js" type="text/javascript"></script>--}}
    <script>
        $(document).ready(function () {

        });


        Dropzone.autoDiscover = false;

        // var u = Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element
        $("form.dropzone").dropzone({ // The camelized version of the ID of the form element
            url: "/bigUpload",
            method: "POST",
            paramName: "file",
            autoProcessQueue: true,
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 10,
            maxFilesize: 500,
            timeout: 3600000,
            dictFileTooBig: "حجم فایل شما  حداکثر می تواند 500 مگابایت باشد",
            dictMaxFilesExceeded: "حداکثر تعداد مجاز انتخاب شما تمام شد",
            dictFallbackMessage: "مرورگر شما قابلیت درگ اند دراپ را پشتیبانی نمی کند!",
            dictInvalidFileType: "فرمت فایل شما باید pdf یا rar باشد.",
            dictResponseError: "خطا در آپلود",
            acceptedFiles: ".pdf,.rar,.mp4",
            previewsContainer: "#dropzone-elements",
            previewTemplate: '<div class="row">' +

                '<div class="col m-portlet">\n' +
                '   <div class="m-portlet__head">\n' +
                '       <div class="m-portlet__head-caption">\n' +
                '           <div class="m-portlet__head-title">\n' +
                '               <h3 class="m-portlet__head-text">\n' +
                '                   فایل <small>جزییات فایل</small>\n' +
                '               </h3>\n' +
                '           </div>\n' +
                '       </div>\n' +
                '   </div>\n' +
                '   <div class="m-portlet__body">\n' +


                '<form method="POST" action="{{action('Web\ContentController@store')}}" accept-charset="UTF-8" class="contentInformationForm form-horizontal" enctype="multipart/form-data">\n' +
                '   <div class="row">\n ' +
                "       <input name='_token' type='hidden' value='{{csrf_token()}}'>\n" +
                "       <div class=\"col-md-2\">" +
                '           <div class="input-group">\n' +
                '               <div class="icheck-inline">\n' +
                '                   <label><input name="enable" type="checkbox" value="1" class="icheck" checked> فعال بودن </label>\n' +
                '               </div>\n' +
                '           </div><!-- end of input-group -->' +
                '           <div class=\"dz-preview dz-file-preview dz-processing dz-error dz-complete\">\n' +
                '               <div class=\"dz-image\"><img data-dz-thumbnail /></div>' +
                '               <div class=\"dz-details\">' +
                '                   <div class=\"dz-size\"><span data-dz-size></span></div>' +
                '                   <div class=\"dz-filename\"><span data-dz-name></span></div>' +
                '               </div>' +
                '               <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>' +
                '               <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>' +
                '               <div class=\"dz-success-mark\">' +
                '                   <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">' +
                '                       <title>Check</title>' +
                '                       <defs></defs>' +
                '                       <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">' +
                '                           <path d=\"M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" stroke-opacity=\"0.198794158\" stroke=\"#747474\" fill-opacity=\"0.816519475\" fill=\"#FFFFFF\" sketch:type=\"MSShapeGroup\"></path>' +
                '                       </g>' +
                '                   </svg>' +
                '               </div>' +
                '               <div class=\"dz-error-mark\">' +
                '                   <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">' +
                '                   <title>Error</title><defs></defs>' +
                '                   <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">' +
                '                       <g id=\"Check-+-Oval-2\" sketch:type=\"MSLayerGroup\" stroke=\"#747474\" stroke-opacity=\"0.198794158\" fill=\"#FFFFFF\" fill-opacity=\"0.816519475\">' +
                '                           <path d=\"M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" sketch:type=\"MSShapeGroup\"></path>' +
                '                       </g>' +
                '                   </g>' +
                '                   </svg>' +
                '               </div>' +
                '           </div><!-- end of dz-preview -->' +
                '       </div><!-- end of col-md-2 -->' +

                //            "<div class=\"col-md-2\"><select name=\"contenttypes[]\" class=\"form-control rootContentTypes\" ></select><select name=\"contenttypes[]\" class=\"form-control childContentTypes\" ></select><div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-image\"><img data-dz-thumbnail /></div>\n  <div class=\"dz-details\">\n    <div class=\"dz-size\"><span data-dz-size></span></div>\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n  <div class=\"dz-success-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Check</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <path d=\"M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" stroke-opacity=\"0.198794158\" stroke=\"#747474\" fill-opacity=\"0.816519475\" fill=\"#FFFFFF\" sketch:type=\"MSShapeGroup\"></path>\n      </g>\n    </svg>\n  </div>\n  <div class=\"dz-error-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Error</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <g id=\"Check-+-Oval-2\" sketch:type=\"MSLayerGroup\" stroke=\"#747474\" stroke-opacity=\"0.198794158\" fill=\"#FFFFFF\" fill-opacity=\"0.816519475\">\n          <path d=\"M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" sketch:type=\"MSShapeGroup\"></path>\n        </g>\n      </g>\n    </svg>\n  </div>\n</div></div>"+
                '       <div class="col-md-10">\n' +
                '            <div class="form-group">\n' +
                '               <div class="row">\n' +
                '                   <label class="col-md-4 control-label" for="validSinceDate">نمایان شدن برای کاربران</label>\n' +
                '                   <div class="col-md-2">\n' +
                '                       <input  type="text" class="form-control validSinceDate" value=""  dir="ltr">\n' +
                '                       <input name="validSinceDate"  type="text" class="form-control d-none">\n' +
                '                   </div>\n' +
                '                   <div class="col-md-2">\n' +
                '                       <input class="form-control m-input m-input--air" name="validSinceTime" placeholder="00:00" value="" dir="ltr">\n' +
                '                   </div>\n' +
                '               </div><!-- end of row -->\n' +
                '            </div>\n' +
                '           <div class="form-group">\n' +
                '               <div class="row">\n' +
                '                   <label class="col-md-2 control-label" for="name">نام :\n' +
                '                       <span class="required"> * </span>\n' +
                '                   </label>\n' +
                '                   <div class="col-md-9">\n' +
                '                       <input type="text" name="name" class="form-control m-input m-input--air"  maxlength="100" >\n' +
                '                       <span class="form-control-feedback">\n' +
                '                           <strong></strong>\n' +
                '                       </span>' +
                '                   </div>\n' +
                '               </div><!-- end of row -->\n' +
                '           </div>\n' +

                '           <div class="form-group description-group">\n' +
                '               <div class="row">\n' +
                '                   <label class="col-md-2 control-label" for="description">توضیح:\n' +
                '                   </label>\n' +
                '                   <div class="col-md-9 description-group-textarea-column">\n' +
                '                       <textarea name="description" class="form-control m-input m-input--air" rows="5"></textarea>\n' +
                '                   </div>\n' +
                '               </div><!-- end of row -->\n' +
                '           </div>\n' +
                '           <div class="form-group">\n' +
                '               <div class="row">\n' +
                '                   <label class="col-md-2 control-label" for="tags">\n' +
                'تگ ها :\n                    ' +
                '                   </label>\n' +
                '                   <div class="col-md-9">\n' +
                '                       <input name="tags" type="text" class="form-control m-input m-input--air input-large" value="" data-role="tagsinput">\n' +
                '                   </div>\n' +
                '               </div><!-- end of row -->\n' +
                '           </div>' +
                '           <div class="form-group">\n' +
                '               <div class="text-center"><button type="submit" class="btn btn-success">\n' +
                '               <i class="fa fa-check"></i> ذخیره اطلاعات</button></div>\n' +
                '           </div>\n' +
                '       </div>\n' +
                '   </div>' +
                '</form>' +


                '<div class="row">' +
                '   <div  class="custom-alerts alert alert-danger fade in margin-top-10 hidden">\n' +
                '        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>\n' +
                '        <i class="fa fa-times-circle"></i>\n' +
                '        <strong></strong>' +
                '    </div>' +
                '</div>' +


                '   </div>\n' +
                '</div>',
            // The setting up of the dropzone
            init: function () {
                this.on("addedfile", function (file) {
                    // file.previewElement.querySelector('[type="submit"]').disabled=true;
                    $("#rootContentTypes").parent("div .col-md-2").removeClass("has-danger");

                    if ($("#rootContentTypes option:selected").val().length === 0) {
                        $("#rootContentTypes").parent("div .col-md-6").addClass("has-danger");
                        this.removeFile(file);
                    }

                    var textArea = file.previewElement.querySelector('textarea[name="description"]');
                    textArea.setAttribute("id", "textarea_" + myDropzone.files.length);
                    $("#textarea_" + myDropzone.files.length).summernote({height: 300});

                    var validSinceDateDom = file.previewElement.querySelector('.validSinceDate');
                    validSinceDateDom.setAttribute("id", "validSinceDate_" + myDropzone.files.length);

                    var validSinceDateInput = file.previewElement.querySelector('input[name="validSinceDate"]');
                    validSinceDateInput.setAttribute("id", "validSinceDateAlt_" + myDropzone.files.length);
                    /*
                    validdSince
                    */
                    $("#validSinceDate_" + myDropzone.files.length).persianDatepicker({
                        altField: '#validSinceDateAlt_' + myDropzone.files.length,
                        altFormat: "YYYY MM DD",
                        observer: true,
                        format: 'YYYY/MM/DD',
                        altFieldFormatter: function (unixDate) {
                            var d = new Date(unixDate).toISOString();
                            return d;
                        }
                    });

                    var validSinceTimeInput = file.previewElement.querySelector('input[name="validSinceTime"]');
                    validSinceTimeInput.setAttribute("id", "validSinceTime_" + myDropzone.files.length);

                    $("#validSinceTime_" + myDropzone.files.length).inputmask("hh:mm", {
                        placeholder: "",
                        clearMaskOnLostFocus: true
                    });
                    // Create the remove button
                    var removeButton = Dropzone.createElement("<a href=";
                    " class=";
                    btn;
                    red;
                    btn - sm;
                    btn - block;
                    " style=";
                    border - radius;
                :
                    18;
                    px;
                    ">Remove</a>";
                )
                    // Capture the Dropzone instance as closure.
                    var _this = this;

                    // Listen to the click event
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // Remove the file preview.
                        _this.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                    });

                    // Add the button to the file preview element.
                    file.previewElement.querySelector('.dz-file-preview').appendChild(removeButton);

                    var rootContentTypeValue = $("#rootContentTypes option:selected").val();
                    var rootContentTypeHidden = Dropzone.createElement("<input type=";
                    hidden;
                    " name=";
                    contenttype_id;
                    " value=";
                    " + rootContentTypeValue + ";
                    ">";
                )
                    file.previewElement.querySelector('.form-horizontal').appendChild(rootContentTypeHidden);

                    var contentSetValue = $("#contentSets option:selected").val();
                    if (contentSetValue.length > 0) {
                        var contentSetHidden = Dropzone.createElement("<input type=";
                        hidden;
                        " name=";
                        contentset_id[];
                        " value=";
                        " + contentSetValue + ";
                        ">";
                    )
                        file.previewElement.querySelector('.form-horizontal').appendChild(contentSetHidden);

                        var orderInput = Dropzone.createElement("<input type=";
                        text;
                        " placeholder=";
                        ترتیب;
                        " name=";
                        order;
                        " value=";
                        ">";
                    )
                        file.previewElement.querySelector('.form-horizontal .description-group .description-group-textarea-column').appendChild(orderInput);
                    }

                    var authorValue = $("#authors option:selected").val();
                    if (authorValue.length > 0) {
                        var authorHidden = Dropzone.createElement("<input type=";
                        hidden;
                        " name=";
                        author_id;
                        " value=";
                        " + authorValue + ";
                        ">";
                    )
                        file.previewElement.querySelector('.form-horizontal').appendChild(authorHidden);
                    }

                    //CODE SNIPPET
//                     if($("#childContentTypes").is(':enabled')) {
//                         var childContentTypeValue = $("#childContentTypes option:selected").val();
//                         var chileContentTypeHidden = Dropzone.createElement("<input type='hidden' name='contenttypes[]' value='" + childContentTypeValue + "'>");
//                         file.previewElement.querySelector('.form-horizontal').appendChild(chileContentTypeHidden);
//
//                         var fileName = file.name;
//                         var i = 0 ;
//                         var j = 2 ;
//                         var subString = [];
//                         var year;
//                         var month;
//                         var day;
//                         do{
//                             subString[i] = fileName.substring(i,j);
//                             i = i + 2;
//                             j = j + 2;
//                         }while(subString[i-2].length>0);
// //                        console.log(subString);
//                         year = subString[0];
//                         month = subString[2];
//                         day = subString[4];
//                         day = day.replace(/^0+/, '');
//                         switch (month){
//                             case "01":
//                                 month = "فروردین";
//                                 break;
//                             case "02":
//                                 month = "اردیبهشت";
//                                 break;
//                             case "03":
//                                 month = "خرداد";
//                                 break;
//                             case "04":
//                                 month = "تیر";
//                                 break;
//                             case "05":
//                                 month = "مرداد";
//                                 break;
//                             case "06":
//                                 month = "شهریور";
//                                 break;
//                             case "07":
//                                 month = "مهر";
//                                 break;
//                             case "08":
//                                 month = "آبان";
//                                 break;
//                             case "09":
//                                 month = "آذر";
//                                 break;
//                             case "10":
//                                 month = "دی";
//                                 break;
//                             case "11":
//                                 month = "بهمن";
//                                 break;
//                             case "12":
//                                 month = "اسفند";
//                                 break;
//                             default:
//                                 break;
//                         }
//
//                         var fileNameSuggestion = day + " " + month + " ماه " + year;
//                         file.previewElement.querySelector('input[name="name"]').value = fileNameSuggestion ;
//                     }

                    //CODE SNIPPET
                    // $("#grades option:selected").map(function()
                    // {
                    //     var gradeHidden = Dropzone.createElement("<input type='hidden' name='grades[]' value='"+this.value+"'>");
                    //     file.previewElement.querySelector('.form-horizontal').appendChild(gradeHidden);
                    // });

                    //code sample:
//                    var majorOptions = $("#majors > option").clone();
//                    var selected = $("#grades option:selected").text();
//                    $.each(majorOptions , function (index,key) {
//                        if(index > 0 ) {
//                            var option = Dropzone.createElement('<option value="" ></option>');
//                            option.text = key.text;
//                            option.value = key.value;
////                            if(key.text == selected) option.selected = key.text ;
//                            file.previewElement.querySelector('.major').appendChild(option);
//                        }
//                    });

                    //CODE SNIPPET
//                    var isEnabled = $("#childContentTypes").is(':enabled');
//                    if(isEnabled){
//                        var childOptions = $("#childContentTypes > option").clone();
//                        $.each(childOptions , function (index,key) {
//                            if(index > 0 ) {
//                                var option = Dropzone.createElement('<option value="" ></option>');
//                                option.text = key.text;
//                                option.value = key.value;
//                                file.previewElement.querySelector('.childContentTypes').appendChild(option);
//                            }
//                        });
//                    }else {
//                        file.previewElement.querySelector('.childContentTypes').style.visibility = 'hidden' ;
//                        file.previewElement.querySelector('.childContentTypes').disabled = true;
//                    }
                });

                var myDropzone = this;

                // First change the button to actually tell Dropzone to process the queue.
//                this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
//                    // Make sure that the form isn't actually being sent.
//                    e.preventDefault();
//                    e.stopPropagation();
//                });
//                this.on("uploadprogress", function(file, progress) {
//                    console.log("File progress", progress);
//                });
                this.on("reset", function () {
                    $("#successMessage").addClass("hidden");
                    $("#errorMessage").addClass("hidden");
                    $("#successMessage .message").html();
                    $("#errorMessage .message").html();
                    // Gets triggered when the form is actually being sent.
                    // Hide the success button or the complete form.
                });
                this.on("maxfilesexceeded", function (file) {
                    $("#errorMessage").removeClass("hidden");
                    $("#errorMessage .message").html("نمی توانید بیش از 1 فایل را در یکبار آپلود نمایید");
                    this.removeAllFiles();
                    this.addFile(file);
                    // Gets triggered when the form is actually being sent.
                    // Hide the success button or the complete form.
                });
                // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                // of the sending event because uploadMultiple is set to true.
                this.on("sending", function (files, xhr, formData) {
//                    console.log(files);
//                    console.log(xhr);
                    xhr.setRequestHeader("X-Datatype", $('select[name=contenttype] :selected').attr("data-title"));
                    var contentset = $('select[name=contentset] :selected').val();
                    if (contentset.length > 0)
                        xhr.setRequestHeader("X-Dataid", contentset + "/HD_720p/");
                    xhr.setRequestHeader("X-Dataname", files.name);
                });


                this.on("success", function (files, response) {
                    // Gets triggered when the files have successfully been sent.
                    // Redirect user or notify of success

                    {{--files.previewElement.querySelector('.form-horizontal').action="{{action("Web\ContentController@store")}}"+"/"+response;--}}
                    //                    files.previewElement.querySelector('.form-horizontal').method="POST";
                    //                    var methodInput = Dropzone.createElement("<input type='hidden' name='_method' value='PUT'>");
                    //                    files.previewElement.querySelector('.form-horizontal').appendChild(methodInput);
                    if (response.fileName.length > 0) {
                        // files.previewElement.querySelector('[type="submit"]').disabled=false;
                        var fileNameHidden = Dropzone.createElement("<input type=";
                        hidden;
                        " name=";
                        file[];
                        " value=";
                        " + response.fileName + ";
                        ">";
                    )
                        files.previewElement.querySelector('.form-horizontal').appendChild(fileNameHidden);
                        if ($("#rootContentTypes").data("title") == "video") {
                            var fileCaptionHidden = Dropzone.createElement("<input type=";
                            hidden;
                            " name=";
                            caption[];
                            " value=";
                            کیفیت;
                            عالی;
                            ">";
                        )
                            files.previewElement.querySelector('.form-horizontal').appendChild(fileCaptionHidden);
                            var fileLabelHidden = Dropzone.createElement("<input type=";
                            hidden;
                            " name=";
                            label[];
                            " value=";
                            hd;
                            ">";
                        )
                            files.previewElement.querySelector('.form-horizontal').appendChild(fileLabelHidden);
                        }
                        /**
                         * Initialize tagsinput behaviour on inputs and selects which have
                         * data-role=tagsinput
                         */
                        $("input[data-role=tagsinput]").tagsinput();
                    } else {
                        $("#my-awesome-dropzone").append("<span class=";
                        m--;
                        font - danger;
                        ">" + "خطا در آپلود فایل " + files.name + "</span></br>" + response.toString() + "</br>";
                    )
                    }

//                    if (typeof(response.sessionData) != "undefined" && response.sessionData != null)
//                        $.each(response.sessionData, function (index, value) {
//                            if (index == 'error' && typeof(value) != "undefined" && value != null) {
//                                $("#errorMessage").removeClass("hidden");
//                                $("#errorMessage .message").html(response.sessionData.error);
//                            }
//                            else if(index == 'success' && typeof(value) != "undefined" && value != null) {
//                                $("#successMessage").removeClass("hidden");
//                                $("#successMessage .message").html(response.sessionData.success);
//                            }
//                        });
                });
                this.on("error", function (files, response) {
                    $("#my-awesome-dropzone").append("<span class=";
                    m--;
                    font - danger;
                    ">" + "خطا در آپلود فایل " + files.name + "</span></br>" + response.toString() + "</br>";
                )
                    // Gets triggered when there was an error sending the files.
                    // Maybe show form again, and notify user of error
                });
            }
        });

        $(document).on('submit', '.contentInformationForm', function (e) {
            e.preventDefault();
            var loadingImage = "<img src = " / acm / extra / loading - arrow.gif;
            " style=";
            20;
            px;
            ">";
            var form = $(this);
            formData = form.serialize();
            url = form.attr("action");
            var submitButton = form.find(':submit');
            submitButton.html(loadingImage);
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
                url: url,
                data: formData,
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        submitButton.html("<i class=\"fa fa-check\"></i> ذخیره اطلاعات");
                        // console.log(response);
                        // console.log(response.responseText);
                        var id = response.id;
                        var message = '<div  class="custom-alerts alert alert-success fade in margin-top-10">\n' +
                            '        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>\n' +
                            '        <i class="fa fa-check-circle"></i>\n' +
                            'محتوا با موفقیت ذخیره شد . آیدی محتوا : ' +
                            '<a target="_blank" href="{{action("Web\ContentController@index")}}/' + id + '/edit">' + id + '</a>' +
                            '    </div>';
                        $("#messageDiv").append(message);
                        toastr["success"]("محتوا با موقیت درج شد", "پیام سیستم");
                        form.closest('.m-portlet').fadeOut();
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
                        submitButton.html("<i class=\"fa fa-check\"></i> ذخیره اطلاعات");
                        toastr["error"]("خطای ۴۲۲ . خطای ورودی ها", "پیام سیستم");
                    },
                    //The status for when there is error php code
                    500: function (response) {
                        console.log(response.responseText);
                    },
                    //The status for when there is error php code
                    503: function (response) {
                        submitButton.html("<i class=\"fa fa-check\"></i> ذخیره اطلاعات");
                        form.closest(".m-portlet").find(".custom-alerts >  strong").html('{{ Lang::get("responseText.Database error.") }}');
                        form.closest(".m-portlet").find(".custom-alerts").removeClass("hidden")
                    }
                },
                cache: false,
                // contentType: false,
                processData: false
            });

        });

    </script>
@endsection
@endpermission
