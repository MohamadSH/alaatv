@extends('partials.templatePage')

@section("content")
    <div class="m-portlet m-portlet--tabs productDetailes">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="fa fa-list-ul"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        لیست کانتنت های منتظر تایید
                        تعداد : {{ optional($contents)->count() }}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th> عکس</th>
                        <th> شماره درس</th>
                        <th>جلسه</th>
                        <th> تیتر</th>
                        <th>توضیحات</th>
                        <th>فعال</th>
                        <th>تاریخ آخرین ویرایش</th>
                        <th>فیلم / جزوه</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($contents))
                        @foreach($contents as $content )
                            <tr>
                                <td>
                                    <a target="_blank"
                                       href="{{route('c.edit' , $content->id)}}">{{ $content->id }}</a>
                                </td>
                                <td>
                                    <img src="{{ $content->thumbnail }}?w=400&h=235" class="img-responsive a--full-width"/>
                                </td>
                                <td>
                                    <a target="_blank" href="{{route('web.set.list.contents' , $content->contentset_id)}}">{{$content->contentset_id}}</a>
                                </td>
                                <td> {{ $content->order }}</td>
                                <td> {{ $content->name }}</td>
                                <td>{!!   $content->description !!}</td>
                                <td>{{($content->enable)?'بله':'خیر'}}</td>
                                <td>{{ $content->UpdatedAt_Jalali() }}</td>
                                <td>
                                    @if($content->contenttype_id == config('constants.CONTENT_TYPE_VIDEO'))
                                        <span class = "m-badge m-badge--wide label-sm m-badge--info"> فیلم </span>
                                    @elseif($content->contenttype_id == config('constants.CONTENT_TYPE_PAMPHLET'))
                                        <span class = "m-badge m-badge--wide label-sm m-badge--brand"> جزوه </span>
                                    @else
                                        {{$content->contenttype->displayName}}
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-accent" href="{{route('c.edit' , $content->id)}}">ویرایش</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

