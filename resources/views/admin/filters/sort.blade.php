<div class="row">
    <div class="col-md-3">
        {{Form::select('sortBy', $sortBy , null, ['class' => 'form-control a--full-width' , 'placeholder'=>'مرتب سازی بر اساس'])}}
    </div>
    <div class="col-md-2">
        {{Form::select('sortType', $sortType , null, ['class' => 'form-control a--full-width'])}}
    </div>
</div>