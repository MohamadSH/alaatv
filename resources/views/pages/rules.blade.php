@extends("app",["pageName"=>"rules"])

@section("pageBar")
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                قوانین و مقررارت
            </li>
        </ol>
    </nav>
@endsection
@section("content")
    <div class = "row">
        <div class = "col-xl-12">
            <!--Begin::Portlet-->
            <div class = "m-portlet m-portlet--full-height ">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                برای استفاده از وب سایت {{$wSetting->site->name}} تبعیت از قوانین زیر الزامی می باشد
                            </h3>
                        </div>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    <div class = "tab-content">
                        <div class = "tab-pane active" id = "m_widget2_tab1_content">
                            <!--Begin::Timeline 3 -->
                            <div class = "m-timeline-3">
                                <div class = "m-timeline-3__items">
                                    <div class = "m-timeline-3__item m-timeline-3__item--info">
                                        <span class = "m-timeline-3__item-time">1</span>
                                        <div class = "m-timeline-3__item-desc">
                                            <span class = "m-timeline-3__item-text">
                                            توجه داشته باشید ثبت سفارش در هر زمان به معنی پذیرفتن کامل کلیه شرایط و قوانین آلاء از سوی کاربر می باشد.
                                            </span>
                                        </div>
                                    </div>
                                    <div class = "m-timeline-3__item m-timeline-3__item--warning">
                                        <span class = "m-timeline-3__item-time">2</span>
                                        <div class = "m-timeline-3__item-desc">
                                            <span class = "m-timeline-3__item-text">
                                            کلیه اصول و رویه های آلاء ، منطبق با قوانین جمهوری اسلامی ، قانون تجارت الکترونیک و قانون حمایت از مصرف کننده است.
                                            </span>
                                        </div>
                                    </div>
                                    <div class = "m-timeline-3__item m-timeline-3__item--brand">
                                        <span class = "m-timeline-3__item-time">3</span>
                                        <div class = "m-timeline-3__item-desc">
                                            <span class = "m-timeline-3__item-text">
                                            کلیه محتوای سایت صرفا متعلق به مجموعه ی آلاء می باشد و هرگونه کپی برداری و استفاده شخصی یا تجاری از آن پی گرد قانونی دارد.
                                            </span>
                                        </div>
                                    </div>
                                    <div class = "m-timeline-3__item m-timeline-3__item--success">
                                        <span class = "m-timeline-3__item-time">4</span>
                                        <div class = "m-timeline-3__item-desc">
                                            <span class = "m-timeline-3__item-text">
                                            مجموعه هر زمان اختیار دارد نسبت به اضافه کردن، تعویض یا حذف خدمات سایت اقدام کند.
                                            </span>
                                        </div>
                                    </div>
                                    <div class = "m-timeline-3__item m-timeline-3__item--danger">
                                        <span class = "m-timeline-3__item-time">5</span>
                                        <div class = "m-timeline-3__item-desc">
                                            <span class = "m-timeline-3__item-text">
                                            تنها راه ارتباط با مجموعه آلاء به جز وب سایت، تماس با شماره های مندرج در صفحه ی تماس با مای سایت می باشد.
                                            </span>
                                        </div>
                                    </div>
                                    <div class = "m-timeline-3__item m-timeline-3__item--info">
                                        <span class = "m-timeline-3__item-time">6</span>
                                        <div class = "m-timeline-3__item-desc">
                                            <span class = "m-timeline-3__item-text">
                                            اگر از پی گیری مسئولین آلاء راضی نیستید می توانید شکایت خود را به ایمیل foratmail [at] gmail [dot] com ارسال کنید.
                                            </span>
                                        </div>
                                    </div>
                                    <div class = "m-timeline-3__item m-timeline-3__item--brand">
                                        <span class = "m-timeline-3__item-time">7</span>
                                        <div class = "m-timeline-3__item-desc">
                                            <span class = "m-timeline-3__item-text">
                                            پس از خرید محصولات دانلودی امکان تغییر سفارش وجود ندارد.
                                            </span>
                                        </div>
                                    </div>
                                    <div class = "m-timeline-3__item m-timeline-3__item--info">
                                        <span class = "m-timeline-3__item-time">8</span>
                                        <div class = "m-timeline-3__item-desc">
                                            <span class = "m-timeline-3__item-text">
                                            استفاده گروهی و یا انتشار محصولات آلاء شرعا حرام و از نظر اخلاقی غیر مجاز می باشد.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End::Timeline 3 -->
                        </div>
                    </div>
                </div>
            </div>
            <!--End::Portlet-->
        </div>
    </div>
@endsection

