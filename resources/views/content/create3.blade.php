@extends("app",["pageName"=>"admin"])

@section('page-css')
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel = "stylesheet" type = "text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item">
                <a class="m-link" href="{{action("Web\AdminController@adminContent")}}">مدیریت محتوا</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">درج محتوای آموزشی</a>
            </li>
        </ol>
    </nav>

@endsection

@section("content")
    @include("systemMessage.flash")
    <div class="row">
        <div class="col">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                درج محتوای آموزشی
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="form-group m-form__group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-success btnShowLastContentData" type="button">
                                            نمایش اطلاعات آخرین محتوا
                                        </button>
                                    </div>
                                    <input type="text" name="lastContentId" id="lastContentId" class="form-control m-input m-input--air" placeholder="شماره درس" dir="ltr">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
    
    
                    {!! Form::open(['method' => 'POST', 'action' => 'Web\ContentController@basicStore', 'id' => 'frmCreateNewContent']) !!}
    
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
                                            {!! Form::select('contenttype_id', $contenttypes, null,['class' => 'form-control m-input m-input--air', 'id' => 'contenttypes']) !!}
                                        </div>
                                    </div>
                                </div>
                
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 control-label" for="contenttypes">ترتیب</label>
                                        <div class="col-md-8">
                                            {!! Form::text('order', null, ['class' => 'form-control m-input m-input--air', 'placeholder'=>'ترتیب' , 'id'=>'order', 'dir'=>'ltr']) !!}
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
                                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'maxlength'=>'100' ]) !!}
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
                                            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'descriptionSummerNote', 'rows' => '5' ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-2 control-label" for="tags">
                                            تگ ها :
                                        </label>
                                        <div class="col-md-10">
                                            <input name="tags" type="text" id="contentTags" class="form-control input-large" value="" data-role="tagsinput">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-check"></i>
                                                درج
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            var lastContentId = $('#lastContentId').val();

            mApp.block('#frmCreateNewContent', {
                overlayColor: "#000000",
                type: "loader",
                state: "success",
                message: "کمی صبر کنید..."
            });
            
            $.ajax({
                type: 'GET',
                url: '/api/v1/c/'+lastContentId,
                data: {},
                dataType: 'json',
                success: function (data) {
                    mApp.unblock('#frmCreateNewContent');
                    if (typeof data.id !== 'undefined') {
                        $('#contenttypes').val(data.contenttype_id);
                        $('#order').val(data.order+1);
                        $('#name').val(data.name);
                        $('#descriptionSummerNote').summernote('code', data.description);
                        $("input[data-role=tagsinput]").tagsinput('destroy');
                        $("input[data-role=tagsinput]").val(data.tags.tags.join());
                        $("input[data-role=tagsinput]").tagsinput({
                            tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
                        });
                    } else {
                        toastr.error('خطای سیستمی رخ داده است.');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    mApp.unblock('#frmCreateNewContent');
                    var message = '';
                    // if (jqXHR.status === 403) {
                    //     message = 'کد وارد شده اشتباه است.';
                    // } else if (jqXHR.status === 422) {
                    //     message = 'کد را وارد نکرده اید.';
                    // } else {
                    //     message = 'خطای سیستمی رخ داده است.';
                    // }

                    message = 'خطای سیستمی رخ داده است.';
                    toastr.error(message);
                    stopWaiting();
                }
            });
        });
        
        
    </script>
@endsection
