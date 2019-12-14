<div class="row" id="a_top_section">
    <div class="col">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__body">

                <input type="hidden" name="favoriteActionUrl" value="{{ route('web.mark.favorite.product', [ 'product' => $product->id ]) }}">
                <input type="hidden" name="unFavoriteActionUrl" value="{{ route('web.mark.unfavorite.product', [ 'product' => $product->id ]) }}">

                <div class="btnFavorite">
                    <img class="btnFavorite-on {{ ($isFavored) ? '' : 'a--d-none' }}" src="https://cdn.alaatv.com/upload/fav-on.svg" width="50">
                    <img class="btnFavorite-off {{ ($isFavored) ? 'a--d-none' : '' }}" src="https://cdn.alaatv.com/upload/fav-off.svg" width="50">
                </div>

                <!--begin::Section-->
                <div class="m-section m-section--last">
                    <div class="m-section__content">
                        <!--begin::Preview-->
                        <div class="row">
                            <div class="col-lg-3">
                                <div>
                                    <img src="{{$product->photo}}?w=400&h=400" alt="عکس محصول@if(isset($product->name)) {{$product->name}} @endif" class="img-fluid productPicture m--marginless a--full-width"/>
                                    <button type="button" class="btn m-btn--square btn-metal a--full-width m--margin-top-15 btnShowRepurchase">
                                        <p class="display-6 m--marginless">
                                            خرید مجدد این دوره
                                        </p>
                                    </button>
                                    {!! Form::hidden('product_id',$product->id) !!}
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">

                                        <div id="mapRoad"></div>

{{--                                        <img src="/acm/image/raheAbrisham/raheAbrisham_konkur.png" class="img-fluid m--marginless a--full-width">--}}
                                    </div>
                                </div>
                                <div class="row no-gutters m--margin-top-15">
                                    <div class="col-6 m--padding-right-5">
                                        <button class="btn m-btn--square btn-success a--full-width btnShowHelpMessage">
                                            <p class="display-5 m--marginless">
                                                من تازه شروع کردم
                                            </p>
                                        </button>
                                    </div>
                                    <div class="col-6 m--padding-left-5">
                                        <button class="btn m-btn--square btn-outline-metal a--full-width" onclick="$('.liveDescriptionRow').AnimateScrollTo();">
                                            <p class="display-5 m--marginless">
                                                مشاهده آخرین تغییرات
                                            </p>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end::Preview-->
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
        <!--end::Portlet-->
    </div>
</div>
