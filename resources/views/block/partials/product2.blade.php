<div class="item carousel a--block-item a--block-type-product2 w-55443211"
     @include('partials.gtm-eec.product', ['position'=>$productKey, 'list'=>$block->title])>

    @if($product->price['final'] !== $product->price['base'])
        <div class="ribbon">
            <span>
                <div class="glow">&nbsp;</div>
                {{ round((1-($product->price['final']/$product->price['base']))*100) }}%
                <span>تخفیف</span>
            </span>
        </div>
    @endif

    <div class="a--block-imageWrapper a--imageWithCaption">

        <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="{{$product->photo}}?w=300&h=300" alt="عکس محصول {{$product->name}}" class="a--full-width lazy-image" width="400" height="400">

        <a href="{{ $product->url }}"
           @include('partials.gtm-eec.product', ['position'=>$productKey, 'list'=>$block->title])
           class="a--gtm-eec-product a--gtm-eec-product-click">

            <div class="a--imageCaptionWarper">
                <div class="a--imageCaptionContent">
                    <div class="a--imageCaptionTitle">
                        {{$product->name}}
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
        <a href="{{$product->url}}"
           @include('partials.gtm-eec.product', ['position'=>$productKey, 'list'=>$block->title])
           class="m-link a--full-width a--gtm-eec-product-click">
            <button type="button" class="btn btn-sm m-btn--air btn-accent a--full-width">
                اطلاعات بیشتر
            </button>
        </a>
    </div>

</div>
