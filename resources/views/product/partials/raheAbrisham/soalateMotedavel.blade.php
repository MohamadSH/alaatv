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

</div>
