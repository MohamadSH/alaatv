<div class="row">
    @if(isset($label))<label class="col-md-3 control-label bold">{{$label}} </label>@endif
    <div class="col-md-4">
        {{Form::select(isset($compareName) ? $compareName : 'filterByCost', ["=" => "برابر با" , ">" => "بیشتر از" , "<" => "کمتر از"] , null, ['class' => 'form-control'])}}
    </div>
    <div class="col-md-5">
        {{Form::text(isset($priceName) ? $priceName : 'cost', null, ['class' => 'form-control filter'])}}
    </div>
</div>