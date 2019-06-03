<div class = "portlet light portlet-fit ">
    <div class = "portlet-body">
        <div class = "mt-element-list">
            <div class = "mt-list-head list-default green-haze">
                <div class = "row">
                    <div class = "col-xs-12">
                        <h4 class = "bold" style = "border-bottom:solid 1px;padding-bottom: 5px">اطلاعات مخاطب</h4>
                        <div class = "list-head-title-container">
                            <div class = "form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class = "col-md-3 control-label" for = "name">نام مخاطب</label>
                                <div class = "col-md-9">
                                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name' ]) !!}
                                    @if ($errors->has('name'))
                                        <span class="form-control-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class = "form-group {{ $errors->has('contacttype_id') ? ' has-danger' : '' }}">
                                <label class = "col-md-3 control-label" for = "contacttype_id">نوع مخاطب</label>
                                <div class = "col-md-9">
                                    {!! Form::select('contacttype_id', $contacttypes , null, ['class' => 'form-control', 'id' => 'contacttype_id' ]) !!}
                                </div>
                                @if ($errors->has('contacttype_id'))
                                    <span class="form-control-feedback">
                                            <strong>{{ $errors->first('contacttype_id') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class = "form-group {{ $errors->has('relative_id') ? ' has-danger' : '' }}">
                                <label class = "col-md-3 control-label" for = "relative_id">نسبت مخاطب</label>
                                <div class = "col-md-9">
                                    {{--{!! Form::select('relative_id', $relatives , null, ['class' => 'form-control', 'id' => 'relative_id', 'placeholder' => 'سایر']) !!}--}}
                                    <text class = "form-control-static">@if(isset($contact->relative->id)) {{$contact->relative->displayName}} @else
                                            <span class = "m-badge m-badge--wide label-sm m-badge--info">نام مشخص</span> @endif
                                    </text>
                                </div>
                                @if ($errors->has('relative'))
                                    <span class="form-control-feedback">
                                            <strong>{{ $errors->first('relative') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "mt-list-container list-default">
                <div class = "mt-list-title uppercase">
                    <span class = "badge badge-default bg-hover-green-jungle">
                        <a class = "font-white" href = "#addPhone" data-toggle = "modal" id = "addPhoneButton"><i class = "fa fa-plus"></i></a>
                    </span>
                </div>
                @if($contact->phones->isEmpty())
                    <div class = "alert alert-info" style = "text-align: center">
                        <h3 class = "bold">شماره ای درج نشده است!</h3>
                    </div>
                @else
                    <h4 class = "font-green bold" style = "border-bottom:solid 1px;padding-bottom: 5px">شماره های مخاطب</h4>
                    <ul>
                        @foreach($contact->phones->sortBy("priority")->sortBy("phonetype_id" ) as $key=>$phone)
                            <li class = "mt-list-item">
                                <div class = "form-body">
                                    <div class = "form-group {{ $errors->has('phoneNumber.'.$key) ? ' has-danger' : '' }}">
                                        <label class = "col-md-3 control-label" for = "phoneNumber">شماره</label>
                                        <div class = "col-md-6">
                                            {!! Form::text('phoneNumber[]', $phone->phoneNumber, ['class' => 'form-control', 'dir' => 'ltr']) !!}
                                            @if ($errors->has('phoneNumber.'.$key))
                                                <span class="form-control-feedback">
                                            <strong>{{ $errors->first('phoneNumber.'.$key) }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "form-group {{ $errors->has('phonetype_id.'.$key) ? ' has-danger' : '' }}">
                                        <label class = "col-md-3 control-label" for = "phonetype_id">نوع</label>
                                        <div class = "col-md-6">
                                            {!! Form::select('phonetype_id[]', $phonetypes, $phone->phonetype->id, ['class' => 'form-control' ]) !!}
                                            @if ($errors->has('phonetype_id.'.$key))
                                                <span class="form-control-feedback">
                                            <strong>{{ $errors->first('phonetype_id.'.$key) }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class = "form-group {{ $errors->has('priority.'.$key) ? ' has-danger' : '' }}">
                                        <label class = "col-md-3 control-label" for = "priority">الویت در بین {{$phone->phonetype->displayName}} ها</label>
                                        <div class = "col-md-6">
                                            {!! Form::text('priority[]', $phone->priority, ['class' => 'form-control' , 'dir' => 'ltr']) !!}
                                            @if ($errors->has('priority.'.$key))
                                                <span class="form-control-feedback">
                                            <strong>{{ $errors->first('priority.'.$key) }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <div class = "portlet-footer">
        <div class = "form-actions">
            <div class = "row">
                <div class = "col-md-offset-8 col-md-3">
                    {!! Form::submit('اصلاح', ['class' => 'btn green-haze']) !!}
                </div>
            </div>
        </div>
    </div>
</div>