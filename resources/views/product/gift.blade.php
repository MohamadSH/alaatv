<div class = "m-portlet m-portlet--mobile">
    <div class = "m-portlet__head">
        <div class = "m-portlet__head-caption">
            <div class = "m-portlet__head-title">
                <h3 class = "m-portlet__head-text">
                    محصولات هدیه
                </h3>
            </div>
        </div>
    </div>
    <div class = "m-portlet__body">

        {!! Form::open(["method" => "PUT" , 'action'=>['Web\ProductController@addGift' , $product] ]) !!}
        <div class = "form-inline {{ $errors->has('gift') ? ' has-danger' : '' }}">
            @include("admin.filters.productsFilter" , [ "listType"=>"childSelect","name"=>"giftProducts" , "defaultValue"=>["value"=>0 , "caption"=>"انتخاب کنید"]])
            @if ($errors->has('gift'))
                <span class="form-control-feedback">
                    <strong>{{ $errors->first('gift') }}</strong>
                </span>
            @endif
            {!! Form::submit("افزودن", ['class' => 'btn red-mint']) !!}
        </div>
        {!! Form::close() !!}

        @if($product->gifts->isNotEmpty())
            @foreach($product->gifts as $gift)
                <hr>
                <div class = "row">
                    <h4 class = "bold col-md-11">
                        {{$gift->name}}
                    </h4>
                    <div>
                        <a class = "col-md-1 removeProductGift" data-role = "{{$gift->id}}" data-target = "#removeProductGiftModal" data-toggle = "modal" style = "color: red">
                            <i class = "fa fa-remove"></i>
                        </a>
                    </div>
                </div>

            @endforeach
        @else
            <hr>
            <div>
                <h3 class = "bold" style = "color: red">محصول هدیه ای ندارد.</h3>
            </div>
        @endif

    </div>
</div>
