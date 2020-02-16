@extends('partials.templatePage',['pageName'=>'admin'])

@section('page-css')
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>--}}
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\AdminController@admin")}}">مدیریت کاربران</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">دفترچه تلفن</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class = "row">
        <div class = "col-md-3"></div>
        <div class = "col-md-6 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            @include('systemMessage.flash')
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                دفترچه تلفن
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <a class = "btn m-btn--air btn-primary" href = "{{action("Web\AdminController@admin")}}"> بازگشت
                            <i class = "fa fa-angle-left"></i>
                        </a>
                    </div>
                </div>
                <div class = "m-portlet__body">

                    @if(isset($userId))
                        <a href = "#addContact" data-toggle = "modal" data-target = "#addContact" class = "btn btn-info m-btn m-btn--icon m-btn--wide">
                            <span>
                                <i class = "fa fa-plus"></i>
                                <span> افزودن مخاطب</span>
                            </span>
                        </a>
                    @endif

                    <hr/>

                    @if($contacts->isEmpty())
                        <div class = "alert alert-info" style = "text-align: center">
                            <h3 class = "bold">شما تاکنون مخاطبی درج نکرده اید!</h3>
                        </div>
                    @else
                        <div class = "table-scrollable">
                            <table class = "table table-bordered table-hover">
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
                                                <span class = "m-badge m-badge--wide label-sm m-badge--info"> نا مشخص </span> @endif
                                        </td>
                                        <td>
                                            <div class = "form-group">
                                                <div class = "col-md-4">
                                                    <a class = "btn" href = "{{action("Web\ContactController@edit", $contact)}}">
                                                        <i class = "fa fa-pencil"></i>
                                                        اصلاح
                                                    </a>
                                                </div>
                                                <div class = "col-md-1">
                                                    {!! Form::open(['method' => 'DELETE' , 'action' => ['Web\ContactController@destroy', $contact]]) !!}
                                                    <button class = "btn btn-danger" type = "submit">
                                                        <i class = "fa fa-remove"></i>
                                                        حذف
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
        </div>
    </div>
    @if(isset($userId))
        {{--Adding Contact Modal--}}
        <!--begin::Modal-->
        <div class = "modal fade" id = "addContact" tabindex = "-1" role = "dialog" aria-labelledby = "exampleModalLabel" aria-hidden = "true">
            <div class = "modal-dialog" role = "document">
                <div class = "modal-content">
                    <div class = "modal-header">
                        <h5 class = "modal-title" id = "addContactModalLabel">افزودن شماره</h5>
                        <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                            <span aria-hidden = "true">&times;</span>
                        </button>
                    </div>
                    {!! Form::open(['method' => 'POST' , 'action' => 'Web\ContactController@store']) !!}
                    <div class = "modal-body">
                        {!! Form::hidden('user_id', $userId) !!}
                        <div class = "row">
                            <div class = "col-md-6">
                                <p class = "{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'phoneNumber'  , 'placeholder'=>'نام مخاطب']) !!}
                                    @if ($errors->has('name'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('name')}}</strong>
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class = "col-md-6">
                                <p class = "{{ $errors->has('contacttype_id') ? ' has-danger' : '' }}">
                                    {!! Form::select('contacttype_id', Arr::prepend($contacttypes->toArray(), 'نوع مخاطب'), null, ['class' => 'form-control', 'id' => 'contacttype_id'  ]) !!}
                                    @if ($errors->has('contacttype_id'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('contacttype_id')}}</strong>
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col-md-6">
                                <p class = "{{ $errors->has('relative_id') ? ' has-danger' : '' }}">
                                    {!! Form::select('relative_id', Arr::prepend($relatives->toArray(),'نسبت مخاطب نامشخص'), null, ['class' => 'form-control', 'id' => 'relative_id' ]) !!}
                                    @if ($errors->has('relative_id'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('relative_id')}}</strong>
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class = "modal-footer">
                        <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">بستن</button>
                        {!! Form::submit('ذخیره' , ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--end::Modal-->
    @endif
@endsection

@section('page-js')
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>--}}
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>--}}
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-extended-modals.min.js" type="text/javascript"></script>--}}

    <script type = "text/javascript">
        @if(count($errors) > 0)
        $('#addContact').modal('show');
        @endif
    </script>

@endsection
{{--@endpermission--}}
