@if($product->samplePhotos != null)

    <div class="m-portlet m-portlet--bordered m-portlet--creative m-portlet--bordered-semi m--margin-top-25 productPamphletWarper" id="productPamphletWarper">
        <div class="m-portlet__body m--padding-top-5 m--padding-bottom-5">
    
            <div class="productPamphletTitle">
                <h3 class="m-portlet__head-text">
                    @include('product.partials.productInfoNav', ['targetId'=>'samplePamphlet'])
                </h3>
            </div>
            
            <div class="m-scrollable m-scroller ps ps--active-y productPamphletBody" data-scrollable="true">
                <div class="container-fluid">
                    <div class="row" id="lightgallery">
                        @foreach ($product->samplePhotos as $samplePhoto)
                            <div class="col-3 col-sm-2 col-md-1 m--padding-left-5 m--padding-right-5 m--margin-top-5 a--imageWithCaption" data-src="{{ $samplePhoto->url }}">
                                <img src="{{ $samplePhoto->url  }}?w=142&h=197" alt="{{ $samplePhoto->title }}" class="img-thumbnail">
                                <div class="a--imageCaptionWarper">
                                    <div class="a--imageCaptionContent">
                                        <div class="a--imageCaptionTitle">نمونه جزوه</div>
                                        <div class="a--imageCaptionDescription">کلیک کنید</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

@endif