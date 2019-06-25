@extends("app")

@section("css")
{{--    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">--}}
@endsection


@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <p> لیست فیلم های ثبت شده برای درس {{ $set->name }} - {{ $set->id  }} </p>
            </div>
            
            <div class="m-portlet m-portlet--tabs productDetailes">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="flaticon-list-2"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                تعداد فیلم های درج شده {{ optional($contents)->count() }}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a target="_blank" href="{{ action('Web\ContentController@create2', ['set'=>$set->id]) }}">
                            <button type="button" class="btn m-btn--pill m-btn--air btn-primary">افزودن محتوا</button>
                        </a>
                        <a href="{{ action('Web\SetController@edit', ['set'=>$set->id]) }}">
                            <button type="button" class="btn m-btn--pill m-btn--air btn-warning">ویرایش</button>
                        </a>
                    </div>
                </div>
                
                <div class="m-portlet__body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
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
                            @if(isset($contents))
                                @foreach($contents as $content )
                                    <tr>
                                        <td>
                                            <a target="_blank"
                                               href="{{action("Web\ContentController@edit" , $content->id)}}">{{ $content->id }}</a>
                                        </td>
                                        <td>
                                            <img src="{{ $content->thumbnail }}?w=400&h=235" class="img-responsive a--full-width"/>
                                        </td>
                                        <td> {{ $content->order }}</td>
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
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection

