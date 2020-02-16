@extends('partials.templatePage' , ["pageName"=> "admin"])

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
    <link href = "/assets/pages/css/profile-rtl.min.css" rel = "stylesheet" type = "text/css"/>
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
                <i class = "fa fa-cogs"></i>
                <span>پیکربندی سایت</span>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>مدیریت اسلاید شو صفحه مقالات</span>
            </li>
        </ul>
    </div>
@endsection

@section("metadata")
    <meta name = "_token" content = "{{ csrf_token() }}">
@endsection

@section("bodyClass")
    class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("content")
    <div class = "row">
        <div class = "col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class = "profile-sidebar">
                <!-- PORTLET MAIN -->
            @include("partials.siteConfigurationSideBar")
            <!-- END PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class = "profile-content">
                <div class = "row">
                    <div class = "col-md-12">
                        <!-- BEGIN PORTLET -->
                        <div class = "portlet light ">
                            <div class = "portlet-title">
                                <div class = "caption caption-md">
                                    <i class = "icon-bar-chart theme-font hide"></i>
                                    <span class = "caption-subject font-blue-madison bold uppercase">جدول اسلایدهای صفحه مقالات</span>
                                    <span class = "caption-helper"><a target = "_blank" href = "{{action("Web\ArticleController@showList")}}">رفتن به صفحه ی مقالات</a></span>
                                </div>
                                <div class = "actions">
                                    @permission((Config::get('constants.INSERT_SLIDESHOW_ACCESS')))
                                    <div class = "btn-group btn-group-devided" data-toggle = "buttons">
                                        <label class = "btn btn-transparent grey-salsa btn-circle btn-sm active">
                                            <a class = "bg-font-dark" data-toggle = "modal" href = "#addSlideModal">
                                                <i class = "fa fa-plus" aria-hidden = "true"></i>
                                                افزودن
                                            </a>
                                        </label>
                                    </div>
                                    @endpermission
                                </div>
                                <div class = "modal fade" id = "addSlideModal" tabindex = "-1" role = "basic" aria-hidden = "true">
                                    <div class = "modal-dialog">
                                        <div class = "modal-content">
                                            <div class = "modal-header">
                                                <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true"></button>
                                                <h4 class = "modal-title">افزودن اسلاید</h4>
                                            </div>
                                            <!-- BEGIN FORM-->
                                            {!! Form::open(['files'=>true,'method' => 'POST' , 'action'=>"SlideShowController@store" ,  'class'=>'form-horizontal']) !!}
                                            <div class = "modal-body">
                                                @permission((Config::get('constants.INSERT_SLIDESHOW_ACCESS')))
                                                @include("slideShow.form")
                                                @endpermission
                                                <div class = "modal-footer">
                                                    <div class = "form-actions">
                                                        <div class = "row">
                                                            <div class = "col-md-offset-3 col-md-9">
                                                                <button type = "submit" class = "btn green">افزودن</button>
                                                                <button type = "button" class = "dark btn btn-outline" data-dismiss = "modal">بستن
                                                                </button>
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
                            </div>
                            <div class = "portlet-body">
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
                                            <th> لینک</th>
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
                                                        <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true"></button>
                                                        <h4 class = "modal-title">حذف فیلد
                                                            <span id = "deleteSlideTitle"></span>
                                                        </h4>
                                                    </div>
                                                    <div class = "modal-body">
                                                        <p> آیا مطمئن هستید؟</p>
                                                        {!! Form::hidden('slide_id', null) !!}
                                                    </div>
                                                    <div class = "modal-footer">
                                                        <button type = "button" data-dismiss = "modal" class = "btn btn-outline dark">لغو
                                                        </button>
                                                        <button type = "button" data-dismiss = "modal" class = "btn green" onclick = "removeSlide()">بله
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
                        <!-- END PORTLET -->
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery.sparkline.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/global/scripts/app.min.js" type = "text/javascript"></script>
@endsection

@section("extraJS")
    <script type = "application/javascript">
        $(document).ready(function () {
            @if(session()->has("success"))
            $("#successMessage > span").text("{{session()->pull("success")}}");
            $("#successMessage").show();
            @endif
        });

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
