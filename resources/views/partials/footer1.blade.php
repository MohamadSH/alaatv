<div class = "page-footer">
    <div class = "page-footer-inner"> @if(isset($wSetting->site->footer)) {!! $wSetting->site->footer !!} @endif</div>
    <div class = "scroll-to-top">
        <i class = "icon-arrow-up"></i>
    </div>
</div>

<!-- begin::Footer -->
<footer class = "m-grid__item m-footer ">
    <div class = "m-container m-container--fluid m-container--full-height m-page__container">
        <div class = "m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
            <div class = "m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
				<span class = "m-footer__copyright">
					{{--2017 &copy; Metronic theme by <a href = "https://keenthemes.com" class = "m-link">Keenthemes</a>--}}
                    @if(isset($wSetting->site->footer)) {!! $wSetting->site->footer !!} @endif
				</span>
            </div>
            <div class = "m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
                <ul class = "m-footer__nav m-nav m-nav--inline m--pull-right">
{{--                    <li class = "m-nav__item">
                    <a href = "{{ action('HomeController@aboutUs') }}" class = "m-nav__link">
                        <span class = "m-nav__link-text">درباره ما</span>
                    </a>
</li>--}}
                    <li class = "m-nav__item">
                        <a target="_blank" href = "https://www.instagram.com/alaa_sanatisharif" class = "m-nav__link">
                            <span class = "m-nav__link-text">اینستاگرام</span>
                        </a>
                    </li>
                    <li class = "m-nav__item">
                        <a target="_blank" href = "https://telegram.me/alaa_sanatisharif" class = "m-nav__link">
                            <span class = "m-nav__link-text">تلگرام</span>
                        </a>
                    </li>
                    <li class = "m-nav__item">
                        <a href = "{{ action("Web\RulesPageController") }}" class = "m-nav__link">
                            <span class = "m-nav__link-text">قوانین</span>
                        </a>
                    </li>
                    <li class = "m-nav__item">
                        <a href = "{{ action("Web\ProductController@search") }}" class = "m-nav__link">
                            <span class = "m-nav__link-text">همایش ها</span>
                        </a>
                    </li>
                    <li class = "m-nav__item">
                        <a href = "{{ action("Web\OrderController@checkoutReview") }}" class = "m-nav__link">
                            <span class = "m-nav__link-text">سبد خرید</span>
                        </a>
                    </li>
                    <li class = "m-nav__item m-nav__item">
                        <a href = "{{ action("Web\ContactUsController") }}" class = "m-nav__link" data-toggle = "m-tooltip" title = "@lang('page.contact us')" data-placement = "left">
                            <i class = "m-nav__link-icon fa fa-question-circle m--icon-font-size-lg3"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer><!-- end::Footer -->
