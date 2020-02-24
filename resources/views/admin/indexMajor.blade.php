@extends('partials.templatePage')

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/datatables/datatables.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
@endsection
@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{route('web.index')}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <i class = "fa fa-cogs"></i>
                <span>پنل درج رشته های {{$parentMajor->name}}</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class = "row">

        <div class = "col-md-12">
            <div class = "portlet box blue">
                <div class = "portlet-title">
                    <div class = "caption">
                        رشته های زیر مجموعه {{$parentMajor->name}}  </div>
                    <div class = "tools"></div>
                </div>
                <div class = "portlet-body">
                    <div class = "col-md-12">
                        {!! Form::open(['method'=>'POST' , 'action'=>'MajorController@store' , 'class'=>'form-horizontal']) !!}
                        {!! Form::hidden('parent', $parentMajor->id) !!}
                        {!! Form::hidden('majortype_id', 2) !!}
                        <div class = "form-body">
                            <div class = "form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class = "col-md-3 control-label">نام رشته</label>
                                <div class = "col-md-6">
                                    <div class = "input-group">
                                        {!! Form::text('name', null, ['class' => 'form-control input-circle']) !!}
                                        {{--<span class="form-control-feedback"> A block of help text. </span>--}}
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="form-control-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class = "form-group {{ $errors->has('majorCode') ? ' has-danger' : '' }}">
                                <label class = "col-md-3 control-label">کد رشته</label>
                                <div class = "col-md-6">
                                    <div class = "input-group">
                                        {!! Form::text('majorCode', null, ['class' => 'form-control input-circle' , 'dir'=>'ltr']) !!}
                                        {{--<span class="form-control-feedback"> A block of help text. </span>--}}
                                    </div>
                                    @if ($errors->has('majorCode'))
                                        <span class="form-control-feedback">
                                        <strong>{{ $errors->first('majorCode') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class = "form-actions text-center">
                            <button type = "submit" class = "btn btn-circle green">ثبت رشته</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    {{--<div class="col-md-6">--}}
                    {{--{!! Form::open(['method'=>'POST' , 'action'=>'MajorController@store' , 'class'=>'form-horizontal']) !!}--}}
                    {{--<div class="form-body">--}}
                    {{--<div class="form-group {{ $errors->has('majorId') ? ' has-danger' : '' }}">--}}
                    {{--<label class="col-md-3 control-label">آیدی رشته</label>--}}
                    {{--<div class="col-md-6">--}}
                    {{--<div class="input-group">--}}
                    {{--{!! Form::text('majorId', null, ['class' => 'form-control input-circle']) !!}--}}
                    {{--<span class="form-control-feedback"> A block of help text. </span>--}}
                    {{--</div>--}}
                    {{--@if ($errors->has('majorId'))--}}
                    {{--<span class="form-control-feedback">--}}
                    {{--<strong>{{ $errors->first('majorId') }}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="form-group {{ $errors->has('نام گرایش') ? ' has-danger' : '' }}">--}}
                    {{--<label class="col-md-3 control-label">کد رشته</label>--}}
                    {{--<div class="col-md-6">--}}
                    {{--<div class="input-group">--}}
                    {{--{!! Form::text('majorChildName', null, ['class' => 'form-control input-circle' , 'dir'=>'ltr']) !!}--}}
                    {{--<span class="form-control-feedback"> A block of help text. </span>--}}
                    {{--</div>--}}
                    {{--@if ($errors->has('majorChildName'))--}}
                    {{--<span class="form-control-feedback">--}}
                    {{--<strong>{{ $errors->first('majorChildName') }}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                    {{--</div>--}}

                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="form-actions text-center">--}}
                    {{--<button type="submit" class="btn btn-circle green">ثبت رشته</button>--}}
                    {{--</div>--}}
                    {{--{!! Form::close() !!}--}}
                    {{--</div>--}}
                    <div class = "col-md-12">
                        <hr>
                    </div>

                    {!! Form::open(['method'=>'PUT' , 'action'=>['MajorController@update',$majors->first()]  , 'class'=>'form-horizontal']) !!}
                    {!! Form::hidden('parentMajorId', $parentMajor->id) !!}

                    <table class = "table table-striped table-bordered table-hover table-checkable order-column" id = "sample_2">
                        <thead>
                        <tr>
                            <th> id</th>
                            <th>کد رشته</th>
                            <th> نام</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($majors as $major)
                            <tr class = "odd gradeX">
                                <td> {{$major->id}} </td>
                                <td style = "width: 20%">
                                    @if(isset($parentMajor->children()->where("major2_id",$major->id)->get()->first()->pivot->majorCode))
                                        {!! Form::text('majorCodes['.$major->id.']', $parentMajor->children()->where("major2_id",$major->id)->get()->first()->pivot->majorCode, ['class' => 'form-control input-circle' , 'dir'=>'ltr' , 'placeholder'=>'عدد کد رشته را وارد کنید']) !!}
                                    @else
                                        {!! Form::text('majorCodes['.$major->id.']', null, ['class' => 'form-control input-circle' , 'dir'=>'ltr' , 'placeholder'=>'عدد کد رشته را وارد کنید']) !!}
                                    @endif
                                </td>
                                <td> {{$major->name}} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type = "submit" class = "btn btn-circle blue">اعمال اصلاحات</button>
                    {!! Form::close() !!}

                    {{--<div  class="cbp-l-loadMore-button margin-top-40" id="pagination-div">--}}
                    {{--<div class="search-page">--}}
                    {{--<div class="search-pagination">--}}
                    {{--<ul class="pagination">--}}
                    {{--{{ $majors->appends(["parent"=>$parentMajor->name])->links() }}--}}
                    {{--</ul>--}}

                    {{--</div>--}}
                    {{--</div>--}}

                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/scripts/datatable.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/datatables/datatables.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/table-datatables-managed.min.js" type = "text/javascript"></script>
@endsection

@section("extraJS")

@endsection

