@if($items->isNotEmpty())
    @foreach ($items->chunk(6) as $chunk)
        <ul class="feeds col-lg-6 col-md-6 col-sm-6 col-xs-6 " >
            @foreach ($chunk as $contentset)
                <li>
                    <a href="@if($contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->isNotEmpty()){{action("EducationalContentController@show", $contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->sortBy("pivot.order")->last()->id)}} @else #@endif">
                        <div class="col1">
                            <div class="cont">
                                <div class="cont-col1">
                                    <div class="label label-sm label-success">
                                        <i class="fa fa-list-alt"></i>
                                    </div>
                                </div>
                                <div class="cont-col2">
                                    <div class="desc">
                                        {{$contentset->name}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col2">
                            {{--<div class="date">{{$content["validSince_Jalali"]}}</div>--}}
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endforeach

@else
    <p class="text-center">
        موردی یافت نشد
    </p>
@endif
<div class="row text-center">
    {{ $items->links() }}
</div>