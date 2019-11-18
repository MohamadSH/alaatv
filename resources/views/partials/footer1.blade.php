{{--<div class="page-footer">--}}
{{--    <div class="page-footer-inner"> @if(isset($wSetting->site->footer)) {!! $wSetting->site->footer !!} @endif</div>--}}
{{--    <div class="scroll-to-top">--}}
{{--        <i class="icon-arrow-up"></i>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="modal fade" id="aboutAlaaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">آلاء</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-justify">
                    آلاء پنجره ای است رو به دور نمای آموزش کشور که می کوشد با اساتید کار بلد و مخاطبان پر تعداد و متعهد خود آموزش همگانی را در چهار گوشه ی این سرزمین در دسترس فرزندان ایران قرار دهد.
                    <br>
                    خدمات اصلی آموزش در آلاء کاملا رایگان بوده و درآمد خدمات جانبی آن صرف برپا نگه داشتن و دوام این مجموعه عام المنفعه می شود. محصولات ما پیش تر با نام های آلاء و تخته خاک در اختیار مخاطبان قرار می گرفت که برای سهولت در مدیریت و دسترسی کاربران اکنون انحصارا با نام آلاء منتشر می شود.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="aboutSharifHighschoolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">آلاء</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-justify">
                    دبیرستان دانشگاه صنعتی شریف در سال 1383 تاسیس و زیر نظر دانشگاه صنعتی شریف فعالیت خود را آغاز کرد. فعالیت های آموزشی آلاء با نظارت دبیرستان دانشگاه شریف انجام می شود.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- begin::Footer -->
<footer class="m-grid__item m-footer">
    <div class="m-container m-container--fluid m-container--full-height m-page__container">
        <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
            <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last d-none">
				<span class="m-footer__copyright">
					{{--2017 &copy; Metronic theme by <a href="https://keenthemes.com" class="m-link">Keenthemes</a>--}}
                    @if(isset($wSetting->site->footer)) {!! $wSetting->site->footer !!} @endif
				</span>
            </div>
            <ul class="m-footer__nav m-nav m-nav--inline alaaNamad d-block">

                <li class="m-nav__item">
                    <a data-toggle="modal" data-target="#aboutAlaaModal">
                        <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="https://cdn.alaatv.com/upload/footer-alaaLogo.png" class="lazy-image" alt="آلاء" data-name="alaa" width="36" height="46" data-toggle="m-tooltip" title="آلاء" data-placement="top"/>
                    </a>
                </li>
                <li class="m-nav__item">
                    <a data-toggle="modal" data-target="#aboutSharifHighschoolModal">
                        <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="https://cdn.alaatv.com/upload/footer-sharifLogo.png" class="lazy-image" alt="دبیرستان دانشگاه شریف آلاء" data-name="sharif-school" width="49" height="46" data-toggle="m-tooltip" title="دبیرستان غیر دولتی دانشگاه صنعتی شریف" data-placement="top"/>
                    </a>
                </li>
                <li class="m-nav__item">
                    <a onclick='window.open("https://trustseal.enamad.ir/Verify.aspx?id=125806&amp;p=gCsnIb3IATIJnVIY", "Popup","toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30")' >
                        <img class="lazy-image" src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="https://cdn.alaatv.com/upload/enamad.png" alt="enamad.ir" style='cursor:pointer' data-name="enamad" width="56" height="46" data-toggle="m-tooltip" title="نماد اعتماد الکترونیکی" data-placement="top">
                    </a>
                </li>
                <li class="m-nav__item" data-toggle="m-tooltip" title="نشان ملی ثبت رسانه های دیجیتال" data-placement="top">
                    <img class="lazy-image" id='jxlzwlaofukznbqejzpesizp' style='cursor:pointer' onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=146279&p=rfthaodsgvkauiwkjyoepfvl", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' alt='logo-samandehi' src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src='https://cdn.alaatv.com/upload/samandehi.png' width="44" height="46"/>
                </li>


            </ul>
            <div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first d-block">
                <ul class="m-footer__nav m-nav m-nav--inline m--pull-right m--margin-top-10 a--full-width text-center">


                    <li class="m-nav__item">
                        <a href="{{ action("Web\RulesPageController") }}" class="m-nav__link" data-toggle="m-tooltip" title="قوانین" data-placement="top">
                            <i class="m-menu__link-icon fa fa-gavel"></i>
                        </a>
                    </li>
                    <li class="m-nav__item m-nav__item">
                        <a href="{{ action("Web\ContactUsController") }}" class="m-nav__link" data-toggle="m-tooltip" title="@lang('page.contact us')" data-placement="top">
                            <i class="m-menu__link-icon fa fa-phone-volume"></i>
                        </a>
                    </li>
                    <li class="m-nav__item m-nav__item">
                        <a href="https://forum.alaatv.com" class="m-nav__link" data-toggle="m-tooltip" title="انجمن آلاء" data-placement="top">
                            <i class="m-menu__link-icon fab fa-hornbill"></i>
                        </a>
                    </li>
                    <li class="m-nav__item">
                        <a target="_blank" href="https://telegram.me/alaa_sanatisharif" class="m-nav__link" data-toggle="m-tooltip" title="تلگرام" data-placement="top">
                            <i class="m-menu__link-icon fab fa-telegram"></i>
                        </a>
                    </li>
                    <li class="m-nav__item">
                        <a target="_blank" href="https://www.instagram.com/alaa_sanatisharif" class="m-nav__link" data-toggle="m-tooltip" title="اینستاگرام" data-placement="top">
                            <i class="m-menu__link-icon fab fa-instagram"></i>
                        </a>
                    </li>

                    {{--                    <li class="m-nav__item">--}}
                    {{--                        <a href="{{ action("Web\ProductController@search") }}" class="m-nav__link">--}}
                    {{--                            <span class="m-nav__link-text">همایش ها</span>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="m-nav__item">--}}
                    {{--                        <a href="{{ action("Web\OrderController@checkoutReview") }}" class="m-nav__link">--}}
                    {{--                            <span class="m-nav__link-text">سبد خرید</span>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="m-nav__item m-nav__item">--}}
                    {{--                        <a href="{{ action("Web\RulesPageController") }}" class="m-nav__link" data-toggle="m-tooltip" title="قوانین" data-placement="top">--}}
                    {{--                            <i class="m-menu__link-icon fa fa-gavel"></i>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}
                </ul>
                <div class="text-center">
                    @if(isset($wSetting->site->footer)) {!! $wSetting->site->footer !!} @endif
                </div>
            </div>
        </div>
    </div>
</footer><!-- end::Footer -->
