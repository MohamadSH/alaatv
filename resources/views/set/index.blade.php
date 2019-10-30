@extends("app")

@section("css")
    {{--    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">--}}
@endsection


@section("content")
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                تعداد ست ها:  {{ optional($sets)->total() }}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a target="_blank" href="{{ action('Web\SetController@create') }}">
                            <button type="button" class="btn m-btn--pill m-btn--air btn-primary">افزودن دسته</button>
                        </a>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>آیدی</th>
                                <th> عکس</th>
                                <th> تیتر</th>
                                <th>فعال</th>
                                <th>نمایش</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($sets))
                                @foreach($sets as $set )
                                    <tr>
                                        <td>
                                            <a target="_blank"
                                               href="{{action("Web\SetController@edit" , $set->id)}}">{{ $set->id }}
                                            </a>
                                        </td>
                                        <td>
                                            <img src="{{ $set->photo }}?w=200&h=100" class="img-responsive a--full-width"/>
                                        </td>
                                        <td> {{ $set->name }}</td>
                                        <td>{{ $set->enable }}</td>
                                        <td>{{ $set->display }}</td>
                                        <td>
                                            <a target="_blank"
                                               href="{{action("Web\SetController@edit" , $set->id)}}">اصلاح
                                            </a>
                                            <a target="_blank"
                                               href="{{action("Web\SetController@indexContent" , $set->id)}}">لیست محتواها
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{$sets->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

