@extends("app",["pageName"=>"admin"])

@section('page-css')
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel = "stylesheet" type = "text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')

    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
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

@section("content")
    @include("systemMessage.flash")
    <div class = "row">
        <div class = "col">
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                درج محتوای آموزشی
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    {!! Form::open(['method' => 'POST', 'action' => 'Web\ContentController@store', 'id' => 'frmCreateNewContent']) !!}
                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                <div class="form-group m-form__group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-success btnShowLastContentData" type="button">
                                                نمایش اطلاعات آخرین محتوا
                                            </button>
                                        </div>
                                        <input type="text" name="contentset_id" id="setId" class="form-control m-input m-input--air" placeholder="شماره درس" dir="ltr">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label" for="validSinceDate">تاریخ نمایان شدن</label>
                                        <div class="col-md-8">
                                            <input id="validSinceDate" type="text" class="form-control">
                                            <input name="validSinceDate" id="validSinceDateAlt" type="text" class="form-control d-none">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label" for="validSinceDate">نام فایل کامل</label>
                                        <div class="col-md-8">
                                            {!! Form::text('fileName', null, ['class' => 'form-control', 'placeholder'=>'( با دات ام پی فر)', 'dir'=>'ltr']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label" for="contenttypes">نوع محتوا</label>
                                        <div class="col-md-8">
                                            {!! Form::select('contenttype_id', $contenttypes, (isset($lastContent)?$lastContent->contenttype_id:null),['class' => 'form-control m-input m-input--air', 'id' => 'contenttypes']) !!}
                                        </div>
                                    </div>
                                </div>
                
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label" for="order">ترتیب</label>
                                        <div class="col-md-8">
                                            {!! Form::text('order', (isset($lastContent)?($lastContent->order+1):null), ['class' => 'form-control m-input m-input--air', 'placeholder'=>'ترتیب' , 'id'=>'order', 'dir'=>'ltr']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label" for="author_id">آیدی دبیر</label>
                                        <div class="col-md-8">
                                            {!! Form::text('author_id', (isset($lastContent)?($lastContent->author_id):null), ['class' => 'form-control m-input m-input--air', 'placeholder'=>'آی دی دبیر' , 'id'=>'author_id', 'dir'=>'ltr']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-2 control-label" for="name">نام :
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-10">
                                            {!! Form::text('name', (isset($lastContent)?$lastContent->name:null), ['class' => 'form-control', 'id' => 'name', 'maxlength'=>'100' ]) !!}
                                            <span class="help-block">
                                                   <strong></strong>
                                               </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-2 control-label" for="description">توضیح:
                                        </label>
                                        <div class="col-md-10">
                                            {!! Form::textarea('description', (isset($lastContent)?$lastContent->description:null), ['class' => 'form-control', 'id' => 'descriptionSummerNote', 'rows' => '5' ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-2 control-label" for="tags">
                                            تگ ها :
                                        </label>
                                        <div class="col-md-10">
                                            <input name="tags" type="text" id="contentTags" class="form-control input-large" value="{{ (isset($lastContent)?(implode(',',$lastContent->tags->tags)):'') }}" data-role="tagsinput">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "col-md-12 text-center m--margin-top-10">
                            <input type = "submit" class = "btn btn-lg m-btn--pill m-btn--air m-btn m-btn--gradient-from-success m-btn--gradient-to-accent" value = "درج">
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>
    
    <script>


        $("input[data-role=tagsinput]").tagsinput({
            tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
        });

        $(document).ready(function () {

            $('#descriptionSummerNote').summernote({height: 300});

            $("#validSinceDate").persianDatepicker({
                altField: '#validSinceDateAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: false
                    }
                },
                altFieldFormatter: function (unixDate) {
                    let targetDatetime = new Date(unixDate);
                    return targetDatetime.getFullYear() + "-" + (targetDatetime.getMonth() + 1) + "-" + targetDatetime.getDate() + ' ' + targetDatetime.getHours() + ':' + targetDatetime.getMinutes() + ':' + targetDatetime.getSeconds();
                }
            });

        });

        $(document).on('click', '.btnShowLastContentData', function () {
            var setId = $('#setId').val();
            getLasContentOfSet(setId, initLastContentData);
        });


        function getLasContentOfSet(setId, callback) {

            mApp.block('#frmCreateNewContent', {
                overlayColor: "#000000",
                type: "loader",
                state: "success",
                message: "کمی صبر کنید..."
            });

            $.ajax({
                type: 'GET',
                url: window.location.origin+window.location.pathname+'?set='+setId,
                data: {},
                dataType: 'json',
                success: function (data) {
                    if (typeof data.url !== 'undefined') {
                        callback(data);
                        mApp.unblock('#frmCreateNewContent');
                    } else {
                        mApp.unblock('#frmCreateNewContent');
                        toastr.error('خطای سیستمی رخ داده است.');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    mApp.unblock('#frmCreateNewContent');
                    toastr.error('خطای سیستمی رخ داده است.');
                }
            });
        }

        function initLastContentData(data) {
            $('#contenttypes').val(data.contenttype_id);
            $('#order').val(data.order+1);
            $('#name').val(data.name);
            $('#author_id').val(data.author.id);
            $('#descriptionSummerNote').summernote('code', data.description);
            $("input[data-role=tagsinput]").tagsinput('destroy');
            $("input[data-role=tagsinput]").val(data.tags.tags.join());
            $("input[data-role=tagsinput]").tagsinput({
                tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
            });
        }
    
    
    </script>
@endsection
