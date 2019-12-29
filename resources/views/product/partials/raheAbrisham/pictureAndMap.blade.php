<div class="row" id="a_top_section">
    <div class="col">
        <!--begin::Portlet-->
        <div class="m-portlet m--margin-bottom-10">
            <div class="m-portlet__body">

                @include('partials.favorite', [
                    'favActionUrl' => route('web.mark.favorite.product', [ 'product' => $product->id ]),
                    'unfavActionUrl' => route('web.mark.unfavorite.product', [ 'product' => $product->id ]),
                    'isFavored' => $isFavored
                ])

                <!--begin::Section-->
                <div class="m-section m-section--last">
                    <div class="m-section__content">
                        <!--begin::Preview-->
                        <div class="row no-gutters">
                            <div class="col-lg-3">
                                <div>
                                    <img src="{{$product->photo}}?w=400&h=400" alt="عکس محصول@if(isset($product->name)) {{$product->name}} @endif" class="img-fluid productPicture m--marginless a--full-width"/>
                                    <button type="button" class="btn m-btn--square btn-metal a--full-width m--margin-top-5 btnShowRepurchase">
                                        <p class="display-6 m--marginless">
                                            خرید مجدد این دوره
                                        </p>
                                    </button>
                                    {!! Form::hidden('product_id',$product->id) !!}
                                </div>
                            </div>
                            <div class="col m--padding-left-5">
                                <div class="row no-gutters">
                                    <div class="col">

                                        <div id="mapContainer">

                                            @include('product.partials.raheAbrisham.mapSvg')

                                        </div>

                                    </div>
                                </div>
                                <div class="row no-gutters m--margin-top-5">
                                    <div class="col-6 m--padding-right-5">
                                        <button class="btn m-btn--square btn-success a--full-width btnShowHelpMessage">
                                            <p class="display-5 m--marginless">
                                                من تازه شروع کردم
                                            </p>
                                        </button>
                                    </div>
                                    <div class="col-6 m--padding-left-5">
                                        <button class="btn m-btn--square btn-outline-metal a--full-width btnShowLiveDescription">
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
