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
    
                    <div class="m--margin-bottom-10">
                        <span class="m-badge m-badge--light m-badge--bordered m-badge-bordered--info">1</span>
                        توجه داشته باشید ثبت سفارش در هر زمان به معنی پذیرفتن کامل کلیه شرایط و قوانین آلاء از سوی کاربر
                        می باشد.
                    </div>
                    <div class="m--margin-bottom-10">
                        <span class="m-badge m-badge--light m-badge--bordered m-badge-bordered--warning">2</span>
                        کلیه اصول و رویه های آلاء ، منطبق با قوانین جمهوری اسلامی ، قانون تجارت الکترونیک و قانون حمایت
                        از مصرف کننده است.
                    </div>
                    <div class="m--margin-bottom-10">
                        <span class="m-badge m-badge--light m-badge--bordered m-badge-bordered--brand">3</span>
                        کلیه محتوای سایت صرفا متعلق به مجموعه ی آلاء می باشد و هرگونه کپی برداری و استفاده شخصی یا تجاری
                        از آن پی گرد قانونی دارد.
                    </div>
                    <div class="m--margin-bottom-10">
                        <span class="m-badge m-badge--light m-badge--bordered m-badge-bordered--success">4</span>
                        مجموعه هر زمان اختیار دارد نسبت به اضافه کردن، تعویض یا حذف خدمات سایت اقدام کند.
                    </div>
                    <div class="m--margin-bottom-10">
                        <span class="m-badge m-badge--light m-badge--bordered m-badge-bordered--danger">5</span>
                        تنها راه ارتباط با مجموعه آلاء به جز وب سایت، تماس با شماره های مندرج در صفحه ی تماس با مای سایت
                        می باشد.
                    </div>
                    <div class="m--margin-bottom-10">
                        <span class="m-badge m-badge--light m-badge--bordered m-badge-bordered--info">6</span>
                        اگر از پی گیری مسئولین آلاء راضی نیستید می توانید شکایت خود را به ایمیل foratmail [at] gmail
                        [dot] com ارسال کنید.
                    </div>
                    <div class="m--margin-bottom-10">
                        <span class="m-badge m-badge--light m-badge--bordered m-badge-bordered--brand">7</span>
                        پس از خرید محصولات دانلودی امکان تغییر سفارش وجود ندارد.
                    </div>
                    <div class="m--margin-bottom-10">
                        <span class="m-badge m-badge--light m-badge--bordered m-badge-bordered--info">8</span>
                        استفاده گروهی و یا انتشار محصولات آلاء شرعا حرام و از نظر اخلاقی غیر مجاز می باشد.
                    </div>
                    
                    
                    
                </div>
            </div>
            <!--End::Portlet-->
        </div>
    </div>
@endsection

