@extends("app" , ["pageName" => "submitRequest"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css" />
@endsection

@section("headPageLevelStyle")
    <link rel="stylesheet" href="{{ mix('/css/page_level_style_all.css') }}">
@endsection

@section("bodyClass")
    class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("metadata")
    @parent()
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>ثبت درخواست اینترنت آسیاتک</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    {{--EXCHANGE LOTTERY--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-12">--}}
                {{--<div class="alert alert-block bg-blue bg-font-blue fade in">--}}
                    {{--<button type="button" class="close" data-dismiss="alert"></button>--}}
                    {{--<h4 class="alert-heading text-center" style="line-height: normal;">نام شما در شرکت کنندگان همایش رایگان حضوری عربی آقای ناصح زاده روز 27 خرداد ثبت شده است</h4>--}}
                    {{--<h4 class="alert-heading text-center" style="line-height: normal;">برای انصراف از شرکت در همایش بر روی دکمه زیر کلیک کنید</h4>--}}
                    {{--<p style="text-align: center;">--}}
                        {{--<button class="btn mt-sweetalert-hamayesh-arabi" data-title="آیا از شرکت خود مطمئنید؟" data-type="warning" data-allow-outside-click="true" data-show-confirm-button="true" data-show-cancel-button="true" data-cancel-button-class="btn-danger" data-cancel-button-text="خیر" data-confirm-button-text="بله شرکت می کنم" data-confirm-button-class="btn-info" style="background: #d6af18;">ثبت نام در همایش حضوری</button>--}}
                        {{--<button class="btn btn-lg" id="bt-cancel-hamayesh-arabi"  style="background: #d6af18;">انصراف می دهم</button>--}}
                    {{--</p>--}}
                {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                {{--ToDo: customzing photo layout for supporting jquery upload--}}
                @include('partials.profileSidebar',['user'=>$user , 'withInfoBox'=>true ])
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">
                                                    اطلاعات
                                    </span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li @if(Empty(session('tabPane')) || strcmp(session('tabPane') , "tab_1_1") == 0) {{ "class=active" }} @endif>
                                        <a href="#tab_1_1" data-toggle="tab">
                                                تکمیل اطلاعات شخصی
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                        <div class="tab-pane @if(Empty(session('tabPane')) || strcmp(session('tabPane') , "tab_1_1") == 0) active @endif" id="tab_1_1">
                                        @if(
                                             (!$user->lockProfile and $user->id == Auth::id()))

                                            @include('user.profile.profileEditView')
                                        @else
                                            @include('user.profile.profileView')
                                        @endif
                                        @if(Session::has('belongsTo') && strcmp(Session::get('belongsTo'),"moreInfo")==0)
                                            @include("systemMessage.flash")
                                        @endif
                                    </div>
                                    <!-- END PERSONAL INFO TAB -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->

        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/profile.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script>
        /**
         * Set token for ajax request
         */
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });

        jQuery(document).ready(function() {
        });

    </script>
@endsection
