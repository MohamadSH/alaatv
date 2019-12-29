<div class="row">
    <div class="col-md-4">
        <div>
            <img class="lazy-image a--full-width"
                 src="https://cdn.alaatv.com/loder.jpg?w=16&h=9"
                 data-src="https://cdn.alaatv.com/upload/raheAbrisham-helpMessagePic.svg"
                 alt="samplePhoto"
                 width="253" height="142">
        </div>
    </div>
    <div class="col-md-8">



        <div class="periodDescription compact">

            @if($periodDescription->count() > 0)
                {!! $periodDescription->first()->description !!}
            @endif

        </div>

        <div class="text-right">
            <button type="button" class="btn m-btn--square btn-metal btnShowTotalPeriodDescription"> مطالعه کامل توضیحات</button>
        </div>
    </div>
</div>
