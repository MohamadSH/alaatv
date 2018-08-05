@if($items->isNotEmpty())
    <div class="row">
        @foreach ($items->chunk(6) as $chunk)
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                    @foreach ($chunk as $contentset)
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-bottom-10" style="min-height: 130px">

                                <div class="col-lg-4 col-md-4 col-sd-4 col-xs-12">
                                    {{--<i class="fa fa-list-alt"></i>--}}
                                    <a href="@if($contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty()){{action("EducationalContentController@show", $contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id)}}
                                            @elseif($contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_PAMPHLET") )->where("enable" , 1)->where('validSince' , '<' , Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty()) {{action("EducationalContentController@show", $contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_PAMPHLET") )->where("enable" , 1)->where('validSince' , '<' , Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id)}}
                                            @else #@endif">
                                        <img src="{{(isset($contentset->photo))?$contentset->photo:"https://cdn.sanatisharif.ir/upload/contentset/departmentlesson/".$contentset->id.".jpg"}}" class="contentset-thumbnail">
                                    </a>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sd-8 col-xs-12 margin-top-10">
                                    <div class="row">
                                        <a href="@if($contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty()){{action("EducationalContentController@show", $contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_VIDEO") )->where("enable" , 1)->where('validSince' , '<' , Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id)}}
                                        @elseif($contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_PAMPHLET") )->where("enable" , 1)->where('validSince' , '<' , Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::now())->timezone('Asia/Tehran'))->isNotEmpty()) {{action("EducationalContentController@show", $contentset->educationalcontents->where("contenttype_id",Config::get("constants.CONTENT_TYPE_PAMPHLET") )->where("enable" , 1)->where('validSince' , '<' , Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Carbon\Carbon::now())->timezone('Asia/Tehran'))->sortBy("pivot.order")->last()->id)}}
                                        @else #@endif">
                                            {{$contentset->name}}
                                        </a>
                                        {{--<div>--}}
                                            {{--<ul class="list-inline">--}}
                                                {{--<li><i class="fa fa-video-camera"></i>&nbsp;50</li>&nbsp;--}}
                                                {{--<li><i class="fa fa-book"></i>&nbsp;10</li>&nbsp;--}}
                                                {{--<li><i class="fa fa-eye"></i>&nbsp;20500</li>&nbsp;--}}
                                            {{--</ul>--}}
                                        {{--</div>--}}
                                        {{--<div class="clearfix util-btn-margin-bottom-5">--}}
                                            {{--<button class="btn blue btn-block">دنبال کردن</button>--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        @endforeach
    </div>
@else
    <p class="text-center">
        موردی یافت نشد
    </p>
@endif
<div class="row text-center">
    {{ $items->links() }}
</div>