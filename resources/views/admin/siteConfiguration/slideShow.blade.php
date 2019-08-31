@permission((Config::get('constants.LIST_SLIDESHOW_ACCESS')))@extends('app' , ['pageName'=> 'admin'])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "#">پیکربندی سایت</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">مدیریت اسلاید شو صفحه اصلی</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class = "row">
        <div class = "col">
            <!-- PORTLET MAIN -->
        @include("partials.siteConfigurationSideBar" )
        <!-- END PORTLET MAIN -->
        </div>
    </div>

    <div class = "row">
        <div class = "col">

            @include("systemMessage.flash")
            <div class = "m-portlet m-portlet--head-sm" m-portlet = "true" id = "m_portlet_tools_3">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <span class = "m-portlet__head-icon">
                                <i class = "fa fa-image"></i>
                            </span>
                            <h3 class = "m-portlet__head-text">
                                جدول اسلایدهای صفحه اصلی
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <ul class = "m-portlet__nav">
                            <li class = "m-portlet__nav-item">
                                <a href = "{{route('web.index')}}" class = "m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class = "fa fa-home"></i>
                                    رفتن به صفحه ی اصلی
                                </a>
                            </li>
                            @permission((config('constants.INSERT_SLIDESHOW_ACCESS')))
                            <li class = "m-portlet__nav-item">
                                <a href = "#addSlideModal" data-toggle = "modal" data-target = "#addSlideModal" class = "m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class = "flaticon-plus"></i>
                                    افزودن
                                </a>
                            </li>

                            <div class = "modal fade" id = "addSlideModal" tabindex = "-1" role = "basic">
                                <div class = "modal-dialog">
                                    <div class = "modal-content">
                                        <div class = "modal-header">
                                            <h5 class = "modal-title" id = "exampleModalLabel">افزودن اسلاید</h5>
                                            <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                                                <span aria-hidden = "true">×</span>
                                            </button>
                                        </div>
                                        <!-- BEGIN FORM-->
                                        {!! Form::open(['files'=>true,'method' => 'POST' , 'action'=>"Web\SlideShowController@store" ,  'class'=>'form-horizontal']) !!}
                                        <div class = "modal-body">
                                            @permission((config('constants.INSERT_SLIDESHOW_ACCESS')))
                                            @include("slideShow.form")
                                            @endpermission
                                            <div class = "modal-footer">
                                                <div class = "form-actions">
                                                    <div class = "row">
                                                        <div class = "col text-center">
                                                            <button type = "submit" class = "btn m-btn--air btn-success m--margin-right-25">افزودن</button>
                                                            <button type = "button" class = "btn m-btn--air btn-brand" data-dismiss = "modal">بستن</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {!! Form::close() !!}
                                        <!-- END FORM-->
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </div>

                            @endpermission
                        </ul>
                    </div>
                </div>
                <div class = "m-portlet__body">


                    {{--<div class = "form-group">
                        <div class = "row">
                            <label class = "col-md-3 control-label">صفحه اسلایدشو</label>
                            <div class = "col-md-6">
                                {!! Form::select(
                                    'websitepage_id',
                                    $websitePages,
                                    null,
                                    [
                                        "id" => "websitepage_id",
                                        "class" => "form-control",
                                        "placeholder" => "صفحه اسلایدشو"
                                    ])
                                !!}
                                <span class="form-control-feedback"></span>
                            </div>
                        </div>
                    </div>--}}

                    <div class = "custom-alerts alert alert-success fade in display-hide" id = "successMessage">
                        <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true"></button>
                        <i class = "fa fa-check-circle"></i>
                        <span></span>
                    </div>
                    <div class = "table-scrollable">
                        <table class = "table table-hover">
                            <thead>
                            <tr>
                                <th> ترتیب</th>
                                <th>عنوان</th>
                                <th> متن</th>
                                <th>لینک</th>
                                <th>صفحه</th>
                                <th> عکس</th>
                                <th> فعال/غیرفعال</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($slides->isEmpty())
                                <tr style = "text-align: center">
                                    <td colspan = "7">
                                        اطلاعاتی برای نمایش وجود ندارد
                                    </td>
                                </tr>
                            @else
                                @include("slideShow.index")
                            @endif
                            </tbody>
                            <div class = "modal fade" id = "removeSlideModal" tabindex = "-1" role = "basic" aria-hidden = "true">
                                <div class = "modal-dialog">
                                    <div class = "modal-content">
                                        <div class = "modal-header">
                                            <h5 class = "modal-title" id = "exampleModalLabel">حذف اسلاید</h5>
                                            <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                                                <span aria-hidden = "true">×</span>
                                            </button>
                                        </div>
                                        <div class = "modal-body">
                                            <p> آیا مطمئن هستید؟</p>
                                            {!! Form::hidden('slide_id', null) !!}
                                        </div>
                                        <div class = "modal-footer">
                                            <button type = "button" data-dismiss = "modal" class = "btn m-btn--air btn-outline-brand">لغو
                                            </button>
                                            <button type = "button" data-dismiss = "modal" class = "btn m-btn--air btn-success" onclick = "removeSlide()">بله
                                            </button>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                </div>
                            </div>
                        </table>
                    </div>

                </div>
            </div>


        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script type = "application/javascript">
        $(document).ready(function () {
            @if(session()->has("success"))
            $("#successMessage > span").text("{{session()->pull("success")}}");
            $("#successMessage").show();
            @endif
        });

        $(document).on("click", ".deleteSlide", function () {
//            var slide_id = $(this).closest('span').find('.slide_id').attr('id');
            var slide_id = $(this).closest('tr').attr('id');
            $("input[name=slide_id]").val(slide_id);
            $("#deleteSlideTitle").text($("#slideName_" + slide_id).text());
        });

        function removeSlide() {
            var slide_id = $("input[name=slide_id]").val();
            $.ajax({
                type: 'POST',
                url: 'slideshow/' + slide_id,
                data: {_method: 'delete'},
                success: function (result) {
                    // console.log(result);
                    // console.log(result.responseText);
                    location.reload();
                },
                error: function (result) {
//                     console.log(result);
//                     console.log(result.responseText);
                }
            });
        }
    </script>
@endsection
@endpermission
