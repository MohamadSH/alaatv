{!! Form::hidden("productId" , $product->id , ["id" => "productId"]) !!}

<div class = "m-portlet m-portlet--mobile">
    <div class = "m-portlet__head">
        <div class = "m-portlet__head-caption">
            <div class = "m-portlet__head-title">
                <h3 class = "m-portlet__head-text">
                    محصولات دوست
                </h3>
            </div>
        </div>
    </div>
    <div class = "m-portlet__body">


        {!! Form::open(["method" => "PUT" , "action" => ["Web\ProductController@addComplimentary" , $product]]) !!}
        <div class = "form-inline {{ $errors->has('complimentaryproducts') ? ' has-error' : '' }}">
            @include("admin.filters.productsFilter" , [ "listType"=>"childSelect","name"=>"complimentaryproducts" , "defaultValue"=>["value"=>0 , "caption"=>"انتخاب کنید"]])
            {!! Form::submit("افزودن", ['class' => 'btn red-mint']) !!}
            @if ($errors->has('complimentaryproducts'))
                <span class = "help-block">
                    <strong>{{ $errors->first('complimentaryproducts') }}</strong>
                </span>
            @endif
        </div>
        {!! Form::close() !!}

        @if($product->complimentaryproducts->isNotEmpty())
            @foreach($product->complimentaryproducts as $complimentary)
                <hr>
                <div class = "row">
                    <h4 class = "bold col-md-11">
                        {{$complimentary->name}}
                    </h4>
                    <div>
                        <a class = "col-md-1" data-target = "#static-{{$complimentary->id}}" data-toggle = "modal" style = "color: red">
                            <i class = "fa fa-remove"></i>
                        </a>
                    </div>
                </div>
                <div id = "static-{{$complimentary->id}}" class = "modal fade" tabindex = "-1" data-backdrop = "static" data-keyboard = "false">
                    <div class = "modal-body">
                        <p> آیا مطمئن هستید؟</p>
                    </div>
                    <div class = "modal-footer">
                        <button type = "button" data-dismiss = "modal" class = "btn btn-outline dark">خیر</button>
                        <button type = "button" data-dismiss = "modal" class = "btn green" onclick = "removeComplimentary('{{action("Web\ProductController@removeComplimentary" , $complimentary , ["product" => $product])}}');">
                            بله
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <hr>
            <div>
                <h3 class = "bold" style = "color: red">محصول دوستی ندارد.</h3>
            </div>
        @endif

    </div>
</div>