<div class="m-accordion m-accordion--default m-accordion--solid m-accordion--section  m-accordion--toggle-arrow soalateMotedavel" id="soalateMotedavel" role="tablist">

    @foreach($faqs as $key=>$faqsItem)

        <!--begin::Item-->
        <div class="m-accordion__item">
            <div class="m-accordion__item-head" role="tab" id="soalateMotedavel_item_{{$key}}_head" data-toggle="collapse" href="#soalateMotedavel_item_{{$key}}_body" aria-expanded="true">
        <span class="m-accordion__item-icon">

        </span>
            <span class="m-accordion__item-title">
                {{ $faqsItem->title }}
            </span>
                <span class="m-accordion__item-mode"></span>
            </div>
            <div class="m-accordion__item-body collapse" id="soalateMotedavel_item_{{$key}}_body" role="tabpanel" aria-labelledby="soalateMotedavel_item_{{$key}}_head" data-parent="#soalateMotedavel">
                <div class="m-accordion__item-content">
                    {!! $faqsItem->body !!}
                </div>
            </div>
        </div>
        <!--end::Item-->

    @endforeach

{{--    <!--begin::Item-->--}}
{{--    <div class="m-accordion__item">--}}
{{--        <div class="m-accordion__item-head" role="tab" id="soalateMotedavel_item_1_head" data-toggle="collapse" href="#soalateMotedavel_item_1_body" aria-expanded="true">--}}
{{--            <span class="m-accordion__item-icon">--}}

{{--            </span>--}}
{{--            <span class="m-accordion__item-title">--}}
{{--                میشه با 10 ساعت مطالعه در هفته، به برنامه این دوره رسید؟--}}
{{--            </span>--}}
{{--            <span class="m-accordion__item-mode"></span>--}}
{{--        </div>--}}
{{--        <div class="m-accordion__item-body collapse show" id="soalateMotedavel_item_1_body" role="tabpanel" aria-labelledby="soalateMotedavel_item_1_head" data-parent="#soalateMotedavel">--}}
{{--            <div class="m-accordion__item-content">--}}
{{--                <p>--}}
{{--                    این نمونه متن توضیحات راه ابریشم هست که در این کادر قرار میگیره، بصورت مختصر و مفید تمام مراحل راه ابریشم و اهداف طی فرایند در این دوره آموزشی دانلودی باید توضیح داده شود. در حد دو خط توضیحات برای پیش نماش کافیست و باقی مطالب در ادامه مطلب و کادر گسترده نمایش داده میشود ...--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!--end::Item-->--}}

{{--    <!--begin::Item-->--}}
{{--    <div class="m-accordion__item">--}}
{{--        <div class="m-accordion__item-head collapsed" role="tab" id="soalateMotedavel_item_2_head" data-toggle="collapse" href="#soalateMotedavel_item_2_body" aria-expanded="false">--}}
{{--            <span class="m-accordion__item-icon"><i class="fa  flaticon-placeholder"></i></span>--}}
{{--            <span class="m-accordion__item-title">--}}
{{--                من صفر صفرم تو ریاضی، بدرد من میخوره؟--}}
{{--            </span>--}}
{{--            <span class="m-accordion__item-mode"></span>--}}
{{--        </div>--}}
{{--        <div class="m-accordion__item-body collapse" id="soalateMotedavel_item_2_body" role="tabpanel" aria-labelledby="soalateMotedavel_item_2_head" data-parent="#soalateMotedavel">--}}
{{--            <div class="m-accordion__item-content">--}}
{{--                <p>--}}
{{--                    این نمونه متن توضیحات راه ابریشم هست که در این کادر قرار میگیره، بصورت مختصر و مفید تمام مراحل راه ابریشم و اهداف طی فرایند در این دوره آموزشی دانلودی باید توضیح داده شود. در حد دو خط توضیحات برای پیش نماش کافیست و باقی مطالب در ادامه مطلب و کادر گسترده نمایش داده میشود ...--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!--end::Item-->--}}

{{--    <!--begin::Item-->--}}
{{--    <div class="m-accordion__item">--}}
{{--        <div class="m-accordion__item-head collapsed" role="tab" id="soalateMotedavel_item_3_head" data-toggle="collapse" href="#soalateMotedavel_item_3_body" aria-expanded="false">--}}
{{--            <span class="m-accordion__item-icon"><i class="fa  flaticon-alert-2"></i></span>--}}
{{--            <span class="m-accordion__item-title">--}}
{{--                صفرتاصد هارو دیدم، من چیکار کنم؟--}}
{{--            </span>--}}
{{--            <span class="m-accordion__item-mode"></span>--}}
{{--        </div>--}}
{{--        <div class="m-accordion__item-body collapse" id="soalateMotedavel_item_3_body" role="tabpanel" aria-labelledby="soalateMotedavel_item_3_head" data-parent="#soalateMotedavel">--}}
{{--            <div class="m-accordion__item-content">--}}
{{--                <p>--}}
{{--                    این نمونه متن توضیحات راه ابریشم هست که در این کادر قرار میگیره، بصورت مختصر و مفید تمام مراحل راه ابریشم و اهداف طی فرایند در این دوره آموزشی دانلودی باید توضیح داده شود. در حد دو خط توضیحات برای پیش نماش کافیست و باقی مطالب در ادامه مطلب و کادر گسترده نمایش داده میشود ...--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!--end::Item-->--}}

{{--    <!--begin::Item-->--}}
{{--    <div class="m-accordion__item">--}}
{{--        <div class="m-accordion__item-head collapsed" role="tab" id="soalateMotedavel_item_4_head" data-toggle="collapse" href="#soalateMotedavel_item_4_body" aria-expanded="false">--}}
{{--            <span class="m-accordion__item-icon"><i class="fa  flaticon-placeholder"></i></span>--}}
{{--            <span class="m-accordion__item-title">--}}
{{--                کسی که آزمون قلمچی ثبت نام کرده، آیا به مشکل بر نمیخوره؟--}}
{{--            </span>--}}
{{--            <span class="m-accordion__item-mode"></span>--}}
{{--        </div>--}}
{{--        <div class="m-accordion__item-body collapse" id="soalateMotedavel_item_4_body" role="tabpanel" aria-labelledby="soalateMotedavel_item_4_head" data-parent="#soalateMotedavel">--}}
{{--            <div class="m-accordion__item-content">--}}
{{--                <p>--}}
{{--                    این نمونه متن توضیحات راه ابریشم هست که در این کادر قرار میگیره، بصورت مختصر و مفید تمام مراحل راه ابریشم و اهداف طی فرایند در این دوره آموزشی دانلودی باید توضیح داده شود. در حد دو خط توضیحات برای پیش نماش کافیست و باقی مطالب در ادامه مطلب و کادر گسترده نمایش داده میشود ...--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <!--end::Item-->--}}

</div>
