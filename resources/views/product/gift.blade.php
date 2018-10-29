<div class="portlet light portlet-fit ">
    <div class="portlet-title">
        <h3 class="list-title uppercase bold">محصولات هدیه</h3>
    </div>
    <div class="portlet-body">
        {!! Form::open(["method" => "PUT" , 'action'=>['ProductController@addGift' , $product] ]) !!}
        <div class="form-inline {{ $errors->has('gift') ? ' has-error' : '' }}">
            @include("admin.filters.productsFilter" , [ "listType"=>"childSelect","name"=>"giftProducts" , "defaultValue"=>["value"=>0 , "caption"=>"انتخاب کنید"]])
            @if ($errors->has('gift'))
                <span class="help-block">
                    <strong>{{ $errors->first('gift') }}</strong>
                </span>
            @endif
            {!! Form::submit("افزودن", ['class' => 'btn red-mint']) !!}
        </div>
        {!! Form::close() !!}

        @if($product->gifts->isNotEmpty())
            @foreach($product->gifts as $gift)
                <hr>
                <div class="row">
                    <h4 class="bold col-md-11">
                        {{$gift->name}}
                    </h4>
                    <div>
                        <a class="col-md-1 removeProductGift" data-role="{{$gift->id}}"
                           data-target="#removeProductGiftModal" data-toggle="modal" style="color: red">
                            <i class="fa fa-remove"></i></a>
                    </div>
                </div>

            @endforeach
        @else
            <hr>
            <div>
                <h3 class="bold" style="color: red">محصول هدیه ای ندارد.</h3>
            </div>
        @endif
    </div>
</div>