<div class="item carousel a--block-item a--block-type-product2
        @if(isset($sort) && $sort) SortItemsList-item @endif
        @if(isset($responsiveClass))
            {{ $responsiveClass }}
        @else
            w-55443211
        @endif"
    @include('partials.gtm-eec.product', ['position'=>$productKey, 'list'=>$gtmEecList])
    @if(isset($sort) && $sort) data-sort="{{$key}}" @endif>

    @include('product.partials.ribbonDiscount')

    <div class="a--block-imageWrapper a--imageWithCaption">

        <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="{{$product->photo}}?w=300&h=300" alt="عکس محصول {{(isset($product->name)) ? $product->name : $product->title}}" class="a--full-width lazy-image" width="400" height="400">

        <a href="{{ (isset($product->url->web)) ? $product->url->web : $product->url }}"
           @include('partials.gtm-eec.product', ['position'=>$productKey, 'list'=>$gtmEecList])
           class="a--gtm-eec-product a--gtm-eec-product-click">

            <div class="a--imageCaptionWarper">
                <div class="a--imageCaptionContent">
                    <div class="a--imageCaptionTitle">
                        @if(isset($product->name))
                            {{$product->name}}
                        @elseif(isset($product->title))
                            {{$product->title}}
                        @endif
                    </div>
                    <div class="a--imageCaptionDescription">
                        <br>
                        @include('product.partials.price',['price' => $product->price])
                    </div>
                </div>
            </div>

        </a>
    </div>

    <div class="text-center">
        <a href="{{ (isset($product->url->web)) ? $product->url->web : $product->url }}"
           @include('partials.gtm-eec.product', ['position'=>$productKey, 'list'=>$gtmEecList])
           class="m-link a--full-width a--gtm-eec-product-click">
            <button type="button" class="btn btn-sm m-btn--air btn-accent a--full-width">
                اطلاعات بیشتر
            </button>
        </a>
    </div>

</div>
