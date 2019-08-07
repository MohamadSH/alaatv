@permission((Config::get('constants.INSERT_PRODUCT_FILE_ACCESS')))@extends('app',['pageName'=>'admin'])

@section('page-css')
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/dropzone/dropzone.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/dropzone/basic.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/icheck/skins/all.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/css/select2.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/css/select2-bootstrap.min.css" rel = "stylesheet" type = "text/css"/>
    <style>
        .datepicker-header {
            direction: ltr;
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
            <li class = "breadcrumb-item " aria-current = "page">
                <a class = "m-link" href = "{{action("Web\AdminController@adminProduct")}}">پنل مدیریتی محصولات</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "{{action("Web\ProductController@edit" , $product)}}">اصلاح محصول {{$product->name}} </a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#"> درج فایل محصول</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include("systemMessage.flash")

    <div class = "row" style = "margin-bottom: 10px">
        <div class = "col-md-12">
            <form id = "my-awesome-dropzone" class = "dropzone dropzone-file-area needsclick dz-clickable">
                @foreach($defaultProductFileOrders as $defaultProductFileOrder)
                    <input type = "hidden" id = "lastProductFileOrder_{{$defaultProductFileOrder["fileTypeId"]}}" value = "{{$defaultProductFileOrder["lastOrder"]}}">
                @endforeach
                <div class = "row">
                    <div class = "col-md-12">
                        @include("admin.filters.productsFilter" , ["listType"=>"ALL" , "name"=>"products"  , "defaultProductFilter"=>$product->id , "title"=>"محصول" , "id"=>"products" , "label"=>["caption"=> "انتخاب محصول"]])
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
                            <span class = "needsclick"><span class = "m-badge m-badge--wide m-badge--info">توجه:</span> فرمت های مجاز <label style = "color:red;">pdf , mp4</label> </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id = "dropzone-elements" class = "dropzone dropzone-previews" style = "background: none; border:none"></div>
@endsection

@section('page-js')
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.min.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/lib/persian-date.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery.input-ip-address-control-1.0.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/dropzone/dropzone.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/icheck/icheck.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-editors.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/form-input-mask.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/form-icheck.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/makeSelect2Single.js" type = "text/javascript"></script>
    <script>


        $(document).ready(function () {

        });

        var u = Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element
            url: "/bigUpload",
            method: "POST",
            paramName: "file",
            autoProcessQueue: true,
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 10,
            maxFilesize: 100,
            dictFileTooBig: "حجم فایل شما  حداکثر می تواند 100 مگابایت باشد",
            dictMaxFilesExceeded: "حداکثر تعداد مجاز انتخاب شما تمام شد",
            dictFallbackMessage: "مرورگر شما قابلیت درگ اند دراپ را پشتیبانی نمی کند!",
            dictInvalidFileType: "",
            dictResponseError: "خطا در آپلود",
            acceptedFiles: ".pdf , .mp4",
            previewsContainer: "#dropzone-elements",
            previewTemplate: '<div class="row"><div class="portlet light">\n' +
                '<div class="portlet-body">\n' +
                '<div class="row">\n ' +
                '<form method="POST" action="{{action('Web\ProductfileController@store')}}" accept-charset="UTF-8" class="productInformationForm form-horizontal" enctype="multipart/form-data">\n' +
                "<input name='_token' type='hidden' value='{{csrf_token()}}'>\n" +
                "<div class=\"col-md-2\">" +
                '<div class="input-group">\n' +
                '            <div class="icheck-inline">\n' +
                '                <label>\n' +
                '                    <input name="enable" type="checkbox" value="1" class="icheck" checked> فعال بودن </label>\n' +
                '            </div>\n' +
                '        </div>' +
                "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-image\"><img data-dz-thumbnail /></div>\n  <div class=\"dz-details\">\n    <div class=\"dz-size\"><span data-dz-size></span></div>\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n  <div class=\"dz-success-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Check</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <path d=\"M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" stroke-opacity=\"0.198794158\" stroke=\"#747474\" fill-opacity=\"0.816519475\" fill=\"#FFFFFF\" sketch:type=\"MSShapeGroup\"></path>\n      </g>\n    </svg>\n  </div>\n  <div class=\"dz-error-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Error</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <g id=\"Check-+-Oval-2\" sketch:type=\"MSLayerGroup\" stroke=\"#747474\" stroke-opacity=\"0.198794158\" fill=\"#FFFFFF\" fill-opacity=\"0.816519475\">\n          <path d=\"M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" sketch:type=\"MSShapeGroup\"></path>\n        </g>\n      </g>\n    </svg>\n  </div>\n</div>" +
                "</div>" +
                //            "<div class=\"col-md-2\"><select name=\"contenttypes[]\" class=\"form-control rootContentTypes\" ></select><select name=\"contenttypes[]\" class=\"form-control childContentTypes\" ></select><div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-image\"><img data-dz-thumbnail /></div>\n  <div class=\"dz-details\">\n    <div class=\"dz-size\"><span data-dz-size></span></div>\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n  <div class=\"dz-success-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Check</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <path d=\"M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" stroke-opacity=\"0.198794158\" stroke=\"#747474\" fill-opacity=\"0.816519475\" fill=\"#FFFFFF\" sketch:type=\"MSShapeGroup\"></path>\n      </g>\n    </svg>\n  </div>\n  <div class=\"dz-error-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Error</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <g id=\"Check-+-Oval-2\" sketch:type=\"MSLayerGroup\" stroke=\"#747474\" stroke-opacity=\"0.198794158\" fill=\"#FFFFFF\" fill-opacity=\"0.816519475\">\n          <path d=\"M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" sketch:type=\"MSShapeGroup\"></path>\n        </g>\n      </g>\n    </svg>\n  </div>\n</div></div>"+
                '<div class="col-md-10">\n' +
                '            <div class="form-group">\n' +
                '                <label class=" col-md-4 control-label" for="validSinceDate">نمایان شدن برای کاربران</label>\n' +
                '                <div class="col-md-2">\n' +
                '                    <input  type="text" class="form-control validSinceDate" value=""  dir="ltr">\n' +
                '                    <input name="validSinceDate"  type="text" class="form-control hidden">\n' +
                '                </div>\n' +
                '                <div class="col-md-2">\n' +
                '                    <input class="form-control" name="time" placeholder="00:00" value="" dir="ltr">\n' +
                '                </div>\n' +
                '            </div>\n' +
                '<div class="form-group col-md-12">\n' +
                '    <label class="col-md-3 control-label" for="productfileType_id">نوع فایل<span class="required" aria-required="true"> * </span></label>\n' +
                '    <div class="col-md-9">\n' +
                '     {!! Form::select("productfiletype_id" , $productFileTypes, null, ["class" => "form-control productFileTypeSelect" , "required"   ]) !!}' +
                '    </div>\n' +
                '</div>\n' +
                '<div class="form-group col-md-12">\n' +
                '    <label class="col-md-3 control-label" for="productFileOrder">ترتیب فایل</label>\n' +
                '    <div class="col-md-9">\n' +
                '          <input type="text" name="order"  class="form-control" dir="ltr" >\n' +
                '    </div>\n' +
                '</div>' +
                '            <div class="form-group">\n' +
                '                <label class="col-md-2 control-label" for="name">نام :\n' +
                '                </label>\n' +
                '                <div class="col-md-9">\n' +
                '                    <input type="text" name="name"  class="form-control"  maxlength="100" >\n' +
                '                       <span class="form-control-feedback">\n' +
                '                           <strong></strong>\n' +
                '                   </span>' +
                '                </div>\n' +
                '            </div>\n' +

                '            <div class="form-group">\n' +
                '                <label class="col-md-2 control-label" for="description">توضیح:\n' +
                '                </label>\n' +
                '                <div class="col-md-9">\n' +
                '                    <textarea name="description" class="form-control" rows="5"></textarea>\n' +
                '                </div>\n' +
                '            </div>\n' +
                '           <div class="form-group">\n' +
                '           <div class="col-md-12 text-center"><button type="submit" class="btn btn-success">\n' +
                '           <i class="fa fa-check"></i> ذخیره اطلاعات</button></div>\n' +
                '            </div>\n' +
                '\n' +
                '        </div>\n' +
                '</form>' +
                '</div>' +
                '<div class="row">' +
                '   <div  class="custom-alerts alert alert-danger fade in margin-top-10 hidden">\n' +
                '        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>\n' +
                '        <i class="fa fa-times-circle"></i>\n' +
                '        <strong></strong>' +
                '    </div>' +
                '</div>' +
                '</div></div></div>',
            // The setting up of the dropzone
            init: function () {
                this.on("addedfile", function (file) {
                    // file.previewElement.querySelector('[type="submit"]').disabled=true;
                    $("#products").parent("div .col-md-2").removeClass("has-danger");


                    if ($("#products option:selected").val().length === 0) {
                        $("#products").parent("div .col-md-2").addClass("has-danger");
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

                    var validSinceTimeInput = file.previewElement.querySelector('input[name="time"]');
                    validSinceTimeInput.setAttribute("id", "validSinceTime_" + myDropzone.files.length);

                    $("#validSinceTime_" + myDropzone.files.length).inputmask("hh:mm", {
                        placeholder: "",
                        clearMaskOnLostFocus: true
                    });

                    var fileTypeInput = file.previewElement.querySelector('select[name="productfiletype_id"]');
                    fileTypeInput.setAttribute("data-role", myDropzone.files.length);

                    var orderInput = file.previewElement.querySelector('input[name="order"]');
                    orderInput.setAttribute("id", "order_" + myDropzone.files.length);
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

                    var productId = $("#products option:selected").val();
                    var productHidden = Dropzone.createElement("<input type=";
                    hidden;
                    " name=";
                    product_id;
                    " value=";
                    " + productId + ";
                    ">";
                )
                    file.previewElement.querySelector('.form-horizontal').appendChild(productHidden);
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
                    xhr.setRequestHeader("X-Datatype", "product");
                    xhr.setRequestHeader("X-Dataid", "{{$product->id}}");
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
                        files.previewElement.querySelector('[type="submit"]').disabled = false;
                        // var fileNameHidden = Dropzone.createElement("<input type='hidden' name='file' value='"+response.fileName+"'>");
                        // files.previewElement.querySelector('.form-horizontal').appendChild(fileNameHidden);
                        var cloudFileHidden = Dropzone.createElement("<input type='hidden' name='cloudFile' value='/paid/{{$product->id}}/" + response.prefix + response.fileName + "'>");
                        files.previewElement.querySelector('.form-horizontal').appendChild(cloudFileHidden);
                    } else {
                        $("#my-awesome-dropzone").append("<span class=";
                        m--;
                        font - danger;
                        ">" + "خطا در آپلود فایل " + files.name + "</span></br>";
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
                    " >" + response.message + " " + files.name + "</span></br>";
                )
                    // Gets triggered when there was an error sending the files.
                    // Maybe show form again, and notify user of error
                });
            }
        };

        $(document).on('submit', '.productInformationForm', function (e) {
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
                        toastr["success"]("محتوا با موقیت درج شد", "پیام سیستم");
                        form.closest('.portlet').fadeOut();
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
                        toastr["error"]("ورودی ها ناقص هستند", "پیام سیستم");
                    },
                    //The status for when there is error php code
                    500: function (response) {
                    },
                    //The status for when there is error php code
                    503: function (response) {
                        submitButton.html("<i class=\"fa fa-check\"></i> ذخیره اطلاعات");
                        form.closest(".portlet").find(".custom-alerts >  strong").html(;\Lang::get("responseText.Database error.");
                    )
                        form.closest(".portlet").find(".custom-alerts").removeClass("hidden")
                    }
                },
                cache: false,
                // contentType: false,
                processData: false
            });
        });

        var videoOrderMap = [];
        var pamphletOrderMap = [];
        $(document).on("change", ".productFileTypeSelect", function () {
            var fileTypeId = $(this).val();
            var lastOrder = $("#lastProductFileOrder_" + fileTypeId).val();

            switch (fileTypeId) {
                case "1":
                    var savedOrder = videoOrderMap["order_" + $(this).data("role")];
                    if (typeof (savedOrder) != "undefined" && savedOrder !== null)
                        $("#order_" + $(this).data("role")).val(savedOrder);
                    else {
                        $("#order_" + $(this).data("role")).val(lastOrder);
                        videoOrderMap["order_" + $(this).data("role")] = lastOrder;
                        lastOrder++;
                        $("#lastProductFileOrder_" + fileTypeId).val(lastOrder);
                    }
                    break;
                case "2":
                    var savedOrder = pamphletOrderMap["order_" + $(this).data("role")];
                    if (typeof (savedOrder) != "undefined" && savedOrder !== null)
                        $("#order_" + $(this).data("role")).val(savedOrder);
                    else {
                        $("#order_" + $(this).data("role")).val(lastOrder);
                        pamphletOrderMap["order_" + $(this).data("role")] = lastOrder;
                        lastOrder++;
                        $("#lastProductFileOrder_" + fileTypeId).val(lastOrder);
                    }
                    break;
                default:
                    break;
            }
        });

    </script>
@endsection
@endpermission
