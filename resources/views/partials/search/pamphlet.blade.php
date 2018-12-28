<i class="la la-file-pdf-o"></i>
@if($items->isNotEmpty())
    <ul class="feeds">
    @foreach($items as $content)
        <!-- TIMELINE ITEM -->
            <li>
                <a href="{{action("ContentController@show", $content->id)}}">
                    <div class="col1">
                        <div class="cont">
                            <div class="cont-col1">
                                <div class="label label-sm label-danger">
                                    <i class="fa fa-file-pdf-o"></i>
                                </div>
                            </div>
                            <div class="cont-col2">
                                <div class="desc">
                                    {{$content->name}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col2">
                        {{--<div class="date">{{$content["validSince_Jalali"]}}</div>--}}
                    </div>
                </a>
            </li>
            <!-- END TIMELINE ITEM -->
        @endforeach
    </ul>
@else
    <p class="text-center">
        موردی یافت نشد
    </p>
@endif
<div class="row text-center">
    {{ $items->links() }}
</div>