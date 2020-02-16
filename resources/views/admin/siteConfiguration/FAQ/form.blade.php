@if(isset($faq))
    {!! Form::hidden('faq_id' , $faq->id) !!}
@endif
<div class="row">
    <div class="form-group col-4 {{ $errors->has('title') ? ' has-danger' : '' }}">
        <label class="control-label">عنوان<span class="required m--font-danger"> * </span></label>
        {!! Form::text("title", (isset($faq))?$faq->title:old('title') , ['class' => 'form-control' , 'required']) !!}
        @if ($errors->has('title'))
            <span class="form-control-feedback">
            <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group col-4  {{ $errors->has('order') ? ' has-danger' : '' }}">
        <label class="control-label">ترتیب</label>
        {!! Form::number("order", (isset($faq))?$faq->order:old('order')  , ['class' => 'form-control' , 'dir' => 'ltr' ]) !!}
        @if ($errors->has('order'))
            <span class="form-control-feedback">
            <strong>{{ $errors->first('order') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group col-4">
        <label class="control-label">لینک فیلم</label>
        {!! Form::text("video", (isset($faq))?$faq->video:null , ['class' => 'form-control' , 'dir' => 'ltr' ]) !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-4  {{ $errors->has('photo') ? ' has-danger' : '' }}">
        <label class="control-label">عکس(jpeg,jpg,png)</label>
        {!! Form::file('photo' , ['class' => 'form-control']) !!}
        @if ($errors->has('photo'))
            <span class="form-control-feedback">
            <strong>{{ $errors->first('photo') }}</strong>
            </span>
        @endif
        @if(isset($faq) && isset($faq->photo))
            <a target="_blank" href="{{\App\Websitesetting::getFaqPhoto($faq)}}"><img
                    src="{{\App\Websitesetting::getFaqPhoto($faq)}}" width="250" height="100"></a>
        @endif
    </div>
</div>
<div class="row">
    <div class="form-group col-12  {{ $errors->has('body') ? ' has-danger' : '' }}">
        <label class="control-label">متن<span class="required m--font-danger"> * </span></label>
        {!! Form::textarea('body', (isset($faq))?$faq->body:old('body')  , ['class' => 'form-control' , 'required']) !!}
        @if ($errors->has('body'))
            <span class="form-control-feedback">
            <strong>{{ $errors->first('body') }}</strong>
            </span>
        @endif
    </div>
</div>
