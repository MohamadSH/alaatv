@extends("app")

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection


@section("bodyClass")
    class="page-header-fixed page-sidebar-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md"
@endsection

@section("pageBar")
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="note note-success">
                <p> لیست فیلم های ثبت شده برای درس {{ $set->name }}  - {{ $set->id  }} </p>
            </div>

            <div class="portlet box yellow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>  تعداد فیلم های درج شده {{ $contents->count() }}
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th> عکس</th>
                                    <th>ترتیب</th>
                                    <th> تیتر</th>
                                    <th>توضیحات</th>
                                    <th>فعال</th>
                                    <th>تاریخ نمایش</th>
                                    <th>فیلم / جزوه</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($contents as $content )
                                <tr>
                                    <td><a target="_blank" href="{{action("EducationalContentController@edit" , $content->id)}}">{{ $content->id }}</a></td>
                                    <td> <img src="{{ optional($content->files->where("pivot.label", "thumbnail")->first())->name }}" class="img-responsive" /></td>
                                    <td> {{ $content->pivot->order }}</td>
                                    <td> {{ $content->name }}</td>
                                    <td>{!!   $content->description !!}</td>
                                    <td>{{ $content->enable }}</td>
                                    <td>{{ $content->validSince }}</td>
                                    @if($content->template_id == 1)
                                        <td>فیلم</td>
                                        @else
                                        <td>جزوه</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
@endsection

@section("footerPageLevelScript")
@endsection

@section("extraJS")
@endsection
