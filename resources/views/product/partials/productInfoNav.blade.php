<div class="productInfoNav-container">
    <div class="productInfoNav productInfoNav-sampleVideo @if($targetId==='sampleVideo') this @endif" data-tid="Block-sampleVideo">
        <span class="redSquare"></span>
        نمونه فیلم ها
    </div>
    <div class="productInfoNav productInfoNav-samplePamphlet @if($targetId==='samplePamphlet') this @endif" data-tid="productPamphletWarper">
        <span class="redSquare"></span>
        نمونه جزوه
    </div>
    <div class="productInfoNav productInfoNav-detailes @if($targetId==='productDetailes') this @endif" data-tid="productDetailes">
        <span class="redSquare"></span>
         بررسی محصول
    </div>
    <div class="productInfoNav productInfoNav-liveDescription @if($targetId==='productLiveDescription') this @endif" data-tid="productLiveDescription">
        <span class="redSquare"></span>
         توضیحات لحظه ای
    </div>
    <div class="productInfoNav productInfoNav-relatedProduct @if($targetId==='relatedProduct') this @endif" data-tid="Block-relatedProduct">
        <span class="redSquare"></span>
         محصولات مرتبط
    </div>

    @if($product->enable && !$isForcedGift)
    <div class="productInfoNav productInfoNav-btnAddToCart">
        <button class="btn m-btn--air btn-success m-btn--icon btnAddToCart gta-track-add-to-card">
            <span>
                <i class="fa fa-cart-arrow-down"></i>
                <i class="fas fa-sync-alt fa-spin m--hide"></i>
            </span>
        </button>
    </div>
    @endif

</div>
