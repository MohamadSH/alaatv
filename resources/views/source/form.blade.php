<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::text('title' , null , ['placeholder' => 'نام' , 'class' => 'form-control' , 'required'] ) !!}
            @if ($errors->has('title'))
                <span class="form-control-feedback">
                    <strong>{{ $errors->first('title')}}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::text('link' , null , ['placeholder' => 'لینک' , 'class' => 'form-control' , 'dir'=>'ltr'] ) !!}
        </div>
    </div>
</div>
<hr>
<h4 style="text-align: center">عکس منبع</h4>
<div class="row">
    {!! Form::file('photo') !!}
    @if ($errors->has('photo'))
        <span class="form-control-feedback m--font-danger">
                <strong>{{ $errors->first('photo')}}</strong>
        </span>
    @endif
</div>
@if(isset($source) && isset($source->photo))
    <div class="row">
        <img width="400" height="200" src="{{$source->photo}}" alt="{{$source->title}}">
    </div>
@endif

