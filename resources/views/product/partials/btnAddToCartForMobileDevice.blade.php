<div class="addToCartForMobileDeviceWrapper" >
    @if($product->enable && !$isForcedGift)


        <button class="btn m-btn--air btn-success m-btn--icon m--margin-bottom-5 btnAddToCart gta-track-add-to-card">
                <span>
                    <i class="fa fa-cart-arrow-down"></i>
                    <i class="fas fa-sync-alt fa-spin m--hide"></i>
                    <span>
                        @if(isset($hasUserPurchasedProduct) && $hasUserPurchasedProduct)
                            خرید مجدد
                        @else
                            افزودن به سبد خرید
                        @endif
                    </span>
                </span>
        </button>

        <div class="m--font-brand a_product-price_mobile-wrapper">
                    <span id="a_product-price_mobile">
                        @include('product.partials.price', ['price'=>$product->price])
                    </span>
        </div>

    @else
        @if(!$product->enable)
            <button class="btn btn-danger btn-lg m-btn  m-btn m-btn--icon">
                        <span>
                            <i class="flaticon-shopping-basket"></i>
                            <span>این محصول غیر فعال است.</span>
                        </span>
            </button>
        @elseif($isForcedGift)
            @if($hasPurchasedEssentialProduct)
                <button class="btn btn-danger btn-lg m-btn  m-btn m-btn--icon">
                        <span>
                            <i class="flaticon-arrows"></i>
                            <span>شما محصول راه ابریشم را خریده اید و این محصول به عنوان هدیه به شما تعلق می گیرد</span>
                        </span>
                </button>
            @else
                <button
                    @include('partials.gtm-eec.product', ['position'=>0, 'list'=>'صفحه نمایش محصول-دکمه افزودن به سبد محصولات اجباری', 'quantity'=>'1'])
                    class="btn m-btn--air btn-success m-btn--icon m--margin-bottom-5 a--gtm-eec-product btnAddSingleProductToCart"
                    data-pid="{{ $shouldBuyProductId }}">
                        <span>
                            <i class="fa fa-cart-arrow-down"></i>
                            <i class="fas fa-sync-alt fa-spin m--hide"></i>
                            <span>این محصول بخشی از {{$shouldBuyProductName}} است برای خرید کلیک کنید </span>
                        </span>
                </button>
            @endif
        @endif
    @endif
</div>
