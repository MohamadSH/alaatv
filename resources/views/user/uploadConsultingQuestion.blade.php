@extends('partials.templatePage' , ["pageName"=>"ConsultingQuestion"])

@section("css")
    <link rel = "stylesheet" href = "{{ mix('/css/all.css') }}">
@endsection

@section("title")
    <title>آلاء|آپلود سؤال مشاوره ای</title>
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
                <span>آپلود سؤال مشاوره ای</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "custom-alerts alert alert-success fade in margin-top-10 hidden" id = "successMessage">
        <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true"></button>
        <i class = "fa fa-check-circle"></i>
        <span class = "message"></span>
    </div>
    <div class = "custom-alerts alert alert-danger fade in margin-top-10 hidden" id = "errorMessage">
        <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true"></button>
        <i class = "fa fa-times-circle"></i>
        <span class = "message"></span>
    </div>
    <div class = "row">
        @if(Auth::user()->completion() == 100)
            <div class = "col-md-12">
                <div class = "m-heading-1 border-green m-bordered">
                    <h3>سوال مشاوره ای خود را از ما بپرسید</h3>
                    <p>شما می توانید پس از ضبط صوتی سؤال مشاوره ای خود ، فایل آن را از طریق پنل زیر آپلود نمایید. فایل صوتی سؤال شما در فیلم مشاوره ای با ذکر نام شما پخش خواهد شد و سپس مشاور محترم پاسخ سؤال شما را به صورت تصویری خواهند داد.</p>
                    <p>پس از آپلود موفقیت آمیز سؤال ، می توانید وضعیت آن را با مراجعه به
                        <a href = "{{action("Web\UserController@userQuestions")}}" class = "btn red btn-outline">لیست سوالات خود</a>
                       مشاهده نمایید.
                    </p>
                </div>
                <form id = "my-awesome-dropzone" class = "col-md-12 dropzone dropzone-file-area needsclick dz-clickable">
                    {{ csrf_field() }}
                    <div class = "row">
                        <div class = "col-md-4"></div>
                        <div class = "col-md-4">
                            {!! Form::text('title', null, ['class' => 'form-control' , 'placeholder'=>'عنوان سؤال شما' ,'id'=>'title' ]) !!}
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
                                <span class = "needsclick"><span class = "m-badge m-badge--wide m-badge--info">توجه:</span>فرمت مجاز <label style = "color:red;">mp3</label> است و حداکثر حجم مجاز <label style = "color:red;">۲</label> مگابایت می باشد. همچنین وارد نمودن عنوان سؤال الزامی است. <label style = "color:red;"></span>

                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-12">
                            <button type = "submit" class = "btn default btn-lg" id = "submit">ارسال</button>
                        </div>
                    </div>

                </form>
            </div>
        @else
            <div class = "col-md-12">
                <div class = "m-heading-1 border-red m-bordered">
                    <h3>پروفایل شما کامل نمی باشد!</h3>
                    <p>کاربر گرامی برای آپلود سؤالات مشاوره ای خود ابتدا باید درصد تکمیل پروفایل شما
                        <span class = "m--font-danger bold">100</span>
                       باشد .
                    </p>
                    <p>پس از تکمیل اطلاعات پروفایل با مراجعه به این صفحه قادر خواهید بود سؤالات مشاوره ای خود را ، که به صورت فایل صوتی ضبط نموده اید ، آپلود نموده و همچنین به لیست سؤالات مشاوره ای خود دسترسی داشته باشید</p>
                    <p>
                        <a href = "{{ action("Web\UserController@show",Auth::user()) }}" class = "btn green-haze btn-outline">تکمیل اطلاعات پروفایل</a>
                    </p>
                </div>
            </div>
        @endif

    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/dropzone/dropzone.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/form-dropzone.min.js" type = "text/javascript"></script>
@endsection

@section("extraJS")
    <script type = "text/javascript">
        Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element

            // The configuration we've talked about above
            url: "{{action("Web\UseruploadController@store")}}",
            paramName: "consultingAudioQuestions",
            autoProcessQueue: false,
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 1,
            maxFilesize: 2,
            dictFileTooBig: "حجم فایل شما  حداکثر می تواند ۲ مگابایت باشد",
            dictMaxFilesExceeded: "حداکثر تعداد مجاز انتخاب شما تمام شد",
            dictFallbackMessage: "مرورگر شما قابلیت درگ اند دراپ را پشتیبانی نمی کند!",
            dictInvalidFileType: "فرمت فایل شما باید mp3 باشد.",
            dictResponseError: "خطا در آپلود",
            acceptedFiles: ".mp3",
            // The setting up of the dropzone
            init: function () {
                $("#successMessage").addClass("hidden");
                $("#errorMessage").addClass("hidden");
                $("#successMessage .message").html();
                $("#errorMessage .message").html();
                this.on("addedfile", function (file) {
                    // Create the remove button
                    var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");

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
                    file.previewElement.appendChild(removeButton);
                });

                var myDropzone = this;

                // First change the button to actually tell Dropzone to process the queue.
                this.element.querySelector("button[type=submit]").addEventListener("click", function (e) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    var titleText = $.trim($('input[name=title]').val());
                    if (titleText == "") {
                        $("#errorMessage").removeClass("hidden");
                        $("#errorMessage .message").html("لطفا عنوان سؤال خود را وارد نمایید!");
                    } else myDropzone.processQueue();
                });
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
                this.on("sending", function (files, response) {
                    // Gets triggered when the form is actually being sent.
                    // Hide the success button or the complete form.
                });
                this.on("success", function (files, response) {
                    // Gets triggered when the files have successfully been sent.
                    // Redirect user or notify of success.
//                    console.log(response);
//                    console.log(response.responseText);
                    if (typeof (response.sessionData) != "undefined" && response.sessionData != null)
                        $.each(response.sessionData, function (index, value) {
                            if (index == 'error' && typeof (value) != "undefined" && value != null) {
                                $("#errorMessage").removeClass("hidden");
                                $("#errorMessage .message").html(response.sessionData.error);
                            } else if (index == 'success' && typeof (value) != "undefined" && value != null) {
                                $("#successMessage").removeClass("hidden");
                                $("#successMessage .message").html(response.sessionData.success);
                            }
                        });
                });
                this.on("error", function (files, response) {
                    // Gets triggered when there was an error sending the files.
                    // Maybe show form again, and notify user of error
//                    console.log(response);
//                    console.log(response.responseText);
//                    console.log(typeof response["consultingAudioQuestions"]);
                    $("#errorMessage").removeClass("hidden");
                    if (typeof response["consultingAudioQuestions"] != "undefined")
                        $("#errorMessage .message").html(response["consultingAudioQuestions"]);
                    else
                        $("#errorMessage .message").html(response);

                });
            }

        }
    </script>
@endsection
