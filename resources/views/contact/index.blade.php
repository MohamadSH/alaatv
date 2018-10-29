{{--@permission((Config::get('constants.SHOW_PRODUCT_ACCESS')))--}}
@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@admin")}}">مدیریت کاربران</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>دفترچه تلفن</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            @include('systemMessage.flash')
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-book font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">دفترچه تلفن</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn btn-sm dark dropdown-toggle" href="{{action("HomeController@admin")}}"> بازگشت
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @if(isset($userId))
                    <div class="btn-group">
                        <a id="" class="btn btn-outline blue" href="#addContact" data-toggle="modal">
                            <i class="fa fa-plus"></i> افزودن مخاطب </a>
                    </div>
                @endif
                <hr/>
                <div class="portlet-body form">
                    @if($contacts->isEmpty())
                        <div class="alert alert-info" style="text-align: center">
                            <h3 class="bold">شما تاکنون مخاطبی درج نکرده اید! </h3>
                        </div>
                    @else
                        <div class="table-scrollable">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th> نام</th>
                                    <th> شماره</th>
                                    <th> نسبت</th>
                                    <th> عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contacts as $contact)
                                    <tr>
                                        <td>{{$contact->name}}</td>
                                        <td>
                                            @if(!$contact->phones->isEmpty())
                                                @foreach($contact->phones->sortBy("priority") as $phone)
                                                    {{$phone->phonetype->displayName}} : {{$phone->phoneNumber}}
                                                    <br>
                                                @endforeach
                                            @else
                                            @endif
                                        </td>
                                        <td>@if(isset($contact->relative->id)){{$contact->relative->displayName}} @else
                                                <span class="label label-sm label-info"> نا مشخص </span> @endif</td>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-4">
                                                    <a class="btn"
                                                       href="{{action("ContactController@edit", $contact)}}"><i
                                                                class="fa fa-pencil"></i> اصلاح </a>
                                                </div>
                                                <div class="col-md-1">
                                                    {!! Form::open(['method' => 'DELETE' , 'action' => ['ContactController@destroy', $contact]]) !!}
                                                    <button class="btn btn-danger" type="submit">
                                                        <i class="fa fa-remove"></i> حذف
                                                    </button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
    @if(isset($userId))
        {{--Adding Contact Modal--}}
        <div id="addContact" class="modal fade" tabindex="-1" data-width="500" data-backdrop="static">
            <div class="modal-header">
                افزودن شماره
            </div>
            {!! Form::open(['method' => 'POST' , 'action' => 'ContactController@store']) !!}
            <div class="modal-body">
                {!! Form::hidden('user_id', $userId) !!}
                <div class="row">
                    <div class="col-md-6">
                        <p class="{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'phoneNumber'  , 'placeholder'=>'نام مخاطب']) !!}
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name')}}</strong>
                                    </span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="{{ $errors->has('contacttype_id') ? ' has-error' : '' }}">
                            {!! Form::select('contacttype_id', array_prepend($contacttypes->toArray(), 'نوع مخاطب'), null, ['class' => 'form-control', 'id' => 'contacttype_id'  ]) !!}
                            @if ($errors->has('contacttype_id'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('contacttype_id')}}</strong>
                                    </span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="{{ $errors->has('relative_id') ? ' has-error' : '' }}">
                            {!! Form::select('relative_id', array_prepend($relatives->toArray(),'نسبت مخاطب نامشخص'), null, ['class' => 'form-control', 'id' => 'relative_id' ]) !!}
                            @if ($errors->has('relative_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('relative_id')}}</strong>
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="form-group">
                    <div class="col-md-8"></div>
                    <div class="col-md-2">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن</button>
                    </div>
                    <div class="col-md-2">
                        {!! Form::submit('ذخیره' , ['class' => 'btn green']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    @endif
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script type="text/javascript">
        @if(count($errors) > 0)
        $('#addContact').modal('show');
        @endif
    </script>
@endsection
{{--@endpermission--}}
