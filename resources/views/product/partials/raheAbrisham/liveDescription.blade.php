<div class="m-timeline-3">
    <div class="m-timeline-3__items">


{{--        <div class="m-timeline-3__item m-timeline-3__item--danger">--}}
{{--            <span class="m-timeline-3__item-time">1398/8/23<br>20:23:02</span>--}}
{{--            <div class="m-timeline-3__item-desc">--}}
{{--                    <span class="m-timeline-3__item-user-name">--}}
{{--                        <a  class="m-timeline-3__item-link">--}}
{{--                            انتشار هفته سوم از فرسنگ سوم راه ابریشم ریاضی تجربی آلاء--}}
{{--                        </a>--}}
{{--                    </span>--}}
{{--                <br>--}}
{{--                <div class="m-timeline-3__item-text">--}}
{{--                    کنکورها و پیش آزومن فرسنگ سوم منتشر شد--}}
{{--                    <br>--}}
{{--                    برنامه مطلاعاتی پیشنهادی آلا برای این هفته--}}
{{--                    <br>--}}
{{--                    <ul>--}}
{{--                        <li>یکشنبه 26 آبان: کنکورچه اول (28 تست، مدت آزمون: 45 دقیقه)</li>--}}
{{--                        <li>یکشنبه 26 آبان: کنکورچه اول (28 تست، مدت آزمون: 45 دقیقه)</li>--}}
{{--                        <li>یکشنبه 26 آبان: کنکورچه اول (28 تست، مدت آزمون: 45 دقیقه)</li>--}}
{{--                        <li>یکشنبه 26 آبان: کنکورچه اول (28 تست، مدت آزمون: 45 دقیقه)</li>--}}
{{--                        <li>یکشنبه 26 آبان: کنکورچه اول (28 تست، مدت آزمون: 45 دقیقه)</li>--}}
{{--                    </ul>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}

        @if(count($liveDescriptions)>0)
            @foreach($liveDescriptions as $liveDescription)
                <div class="m-timeline-3__item m-timeline-3__item--danger">
                    <span class="m-timeline-3__item-time">{{$liveDescription->CreatedAt_Jalali_WithTime()}}</span>
                    <div class="m-timeline-3__item-desc">
                    <span class="m-timeline-3__item-user-name">
                        <a  class="m-timeline-3__item-link">
                            {{$liveDescription->title}}
                        </a>
                    </span>
                        <br>
                        <div class="m-timeline-3__item-text">
                            {!!  $liveDescription->description !!}
                        </div>

                    </div>
                </div>
            @endforeach
        @else
            <div class="m-alert m-alert--outline alert alert-info alert-dismissible fade show" role="alert">
                تاکنون توضیحی منتشر نشده است.
            </div>
        @endif




    </div>
</div>
