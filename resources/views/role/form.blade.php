@if(isset($role))
    <div class = "form-body">
        <div class = "note note-warning">
            <h4 class = "caption-subject font-dark bold uppercase">
                وارد کردن اطلاعات زیر الزامیست:
            </h4>
        </div>
        <div class = "form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "name">نام</label>
                <div class = "col-md-9">
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name' ]) !!}
                    @if ($errors->has('name'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('display_name') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "display_name">نام قابل نمایش</label>
                <div class = "col-md-9">
                    {!! Form::text('display_name', null, ['class' => 'form-control', 'id' => 'display_name' ]) !!}
                    @if ($errors->has('display_name'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('display_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <br>
        <div class = "note note-info">
            <h4 class = "caption-subject font-dark bold uppercase">
                وارد کردن اطلاعات زیر اختیاری می باشد:
            </h4>
        </div>
        <div class = "form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "description">توضیح نقش</label>
                <div class = "col-md-9">
                    {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'description' ]) !!}
                    @if ($errors->has('description'))
                        <span class="form-control-feedback">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('permissions') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "permissions">دسترسی</label>
                <div class = "col-md-9">
                    {!! Form::select('permissions[]',$permissions,$rolePermissions,['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default', 'id' => 'role_permission' , "data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" , "data-height" => "200" , "title" => "دسترسی ها"]) !!}
                    @if ($errors->has('permissions'))
                        <span class="form-control-feedback">
                    <strong>{{ $errors->first('permissions') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-actions">
            <div class = "row">
                <div class = "col-md-offset-3 col-md-9">
                    {!! Form::submit('اصلاح', ['class' => 'btn m-btn--air btn-primary' ] ) !!}
                </div>
            </div>
        </div>
    </div>
@else
    <div class = "col-md-12">
        <p class = "caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر الزامی می باشد:</p>
    </div>
    <div class = "col-md-8 col-md-offset-2">
        <p>
            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'roleName' , 'placeholder'=>'نام نقش']) !!}
            <span class="form-control-feedback" id = "roleNameAlert">
                <strong></strong>
            </span>
        </p>

        <p>
            {!! Form::text('display_name', null, ['class' => 'form-control', 'id' => 'roleDisplayName' , 'placeholder'=>'نام قابل نمایش']) !!}
            <span class="form-control-feedback" id = "roleDisplayNameAlert">
                <strong></strong>
            </span>
        </p>
    </div>
    <div class = "col-md-12">
        <p class = "caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری می باشد:</p>
    </div>
    <div class = "col-md-8 col-md-offset-2">
        <p>
            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'roleDescription' , 'placeholder'=>'توضیح درباره نقش']) !!}
            <span class="form-control-feedback" id = "roleDescriptionAlert">
                <strong></strong>
            </span>
        </p>

        <p>
            <label class = "control-label">دسترسی</label>
            {!! Form::select('permissions[]', $permissions, null, ['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default', 'id' => 'role_permission' , "data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" , "data-height" => "200" , "title" => "دسترسی ها"]) !!}
            <span class="form-control-feedback" id = "permissionAlert">
                    <strong></strong>
            </span>
        </p>
    </div>
@endif