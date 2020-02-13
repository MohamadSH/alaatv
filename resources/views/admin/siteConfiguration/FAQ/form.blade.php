@if(isset($faq))
    {!! Form::hidden('faq_id' , $faq->id) !!}
@endif
<div class="row">
    <div class="form-group col-4">
        <label class="control-label">عنوان</label>
        {!! Form::text("title", (isset($faq))?$faq->title:null , ['class' => 'form-control', 'required']) !!}
    </div>
    <div class="form-group col-4">
        <label class="control-label">ترتیب</label>
        {!! Form::text("order", (isset($faq))?$faq->order:null , ['class' => 'form-control' , 'dir' => 'ltr' ]) !!}
    </div>
    <div class="form-group col-4">
        <label class="control-label">لینک فیلم</label>
        {!! Form::text("video", (isset($faq))?$faq->video:null , ['class' => 'form-control' , 'dir' => 'ltr' ]) !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-4">
        <label class="control-label">فایل تامبنیل</label>
        {!! Form::file('photo' , ['class' => 'form-control']) !!}
        @if(isset($faq) && isset($faq->thumbnail))
            <a target="_blank" href="{{$faq->thumbnails}}"><img src="{{$faq->thumbnail}}" width="250" height="100"></a>
        @endif
    </div>
</div>
<div class="row">
    <div class="form-group col-12">
        <label class="control-label">متن</label>
        {!! Form::textarea('body', (isset($faq))?$faq->body:null , ['class' => 'form-control' , 'required']) !!}
    </div>
</div>
