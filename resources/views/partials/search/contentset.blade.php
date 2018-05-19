@if($items->isNotEmpty())
    @foreach ($items->chunk(6) as $chunk)
        <ul class="feeds col-lg-6 col-md-6 col-sm-6 col-xs-6 " >
            @foreach ($chunk as $contentset)
                <li>
                    <a href="@if($contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->isNotEmpty()){{action("EducationalContentController@show", $contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->sortBy("pivot.order")->last()->id)}} @else #@endif">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sd-12 col-xs-12">
                                <div class="col-lg-4 col-md-2 col-sd-2 col-xs-2">
                                    {{--<i class="fa fa-list-alt"></i>--}}
                                    <img src="{{(isset($contentset->photo))?$contentset->photo:"https://cdn.sanatisharif.ir/upload/contentset/departmentlesson/".$contentset->id.".jpg"}}" style="width: 200px; height: 113px; ">
                                </div>
                                <div class="col-lg-8 col-md-10 col-sd-10 col-xs-10">
                                    {{$contentset->name}}
                                </div>
                            </div>
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