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
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand  m-tabs-line--right m-tabs-line-danger" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#productInformation" role="tab" aria-selected="true">
                                    <i class="flaticon-information"></i>
                                    <h5>
                                        تعداد فیلم های درج شده {{ $contents->count() }}
                                    </h5>
                                </a>
                            </li>
                        </ul>
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
                            @foreach($contents as $content )
                                <tr>
                                    <td>
                                        <a target="_blank" href="{{action("Web\ContentController@edit" , $content->id)}}">{{ $content->id }}</a>
                                    </td>
                                    <td>
                                        <img src="{{ $content->thumbnail }}" class="img-responsive a--full-width"/>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection

