<div class = "row">
    <div class = "col-md-12">
        {!! Form::text('address' , null, ['class' => 'form-control filter', 'id' => 'addressFilter', 'placeholder' => 'آدرس']) !!}
    </div>
    <div class = "col-md-12">
        {!! Form::select('addressSpecialFilter',$addressSpecialFilter,null,['class' => 'form-control a--full-width' , 'id'=>'addressSpecialFilter']) !!}
    </div>
</div>