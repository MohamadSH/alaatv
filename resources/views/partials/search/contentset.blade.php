@if($items->isNotEmpty())
    <ul class="feeds" >
        @foreach($items as $contentset)
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
@else
    <p class="text-center">
        موردی یافت نشد
    </p>
@endif
<div class="row text-center">
    {{ $items->links() }}
</div>