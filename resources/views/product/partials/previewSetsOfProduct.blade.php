@if(
    isset($sets) &&
    isset($products) &&
    (
        ($products->count() === 0 && $sets->count() > 0) ||
        ($products->count() > 0)
    )
)
    @if($products->count() === 0 && $sets->count() > 0)
    @else
        <div class="alert alert-danger m--padding-30 m--margin-bottom-5 selectSetOfProductToPreview" role="alert">
            <div class="row">
                <div class="col-md-6 selectProductToPreviewSets">
                    @if(isset($products) && $products->count() > 0)
                        <div class="a--full-width">
                            انتخاب محصول:
                        </div>
                        <div class="CustomDropDown a--full-width" id="selectProduct">
                            <select>
                                @foreach($products as $productItem)
                                    <option value="{{$productItem['id']}}" @if($productItem['id']===$product->id) selected @endif>{{ $productItem['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <i class="fa fa-chevron-left selectProductArrow"></i>
                    @elseif(isset($title))
                        <p class="display-6 m--marginless">
                            {!! $title !!}
                        </p>
                    @endif
                </div>
                <div class="col-md-6">
                    <div>
                        انتخاب دوره:
                    </div>
                    <div class="CustomDropDown" id="selectSet">
                        <select>
                            @foreach($sets as $setItem)
                                <option value="{{$setItem['id']}}" @if($lastSet->id===$setItem['id']) selected @endif>{{$setItem['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row previewContentSetOfProduct">
        <div class="col">
            <div class="m-portlet previewSetsOfProduct">
                <div class="m-portlet__body">
                    <div class="closeBtn">
                        <a href="#" data-toggle="m-tooltip" data-placement="top" data-original-title="مشاهده تمام فیلم ها و جزوات" >
                            <i class="fa fa-share-square m--font-danger btnShowMoreContents"></i>
                        </a>
                    </div>
                    <div class="sectionFilterCol"></div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#m_tabs_video">فیلم ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#m_tabs_pamphlet">جزوات</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_tabs_video" role="tabpanel">
                            <div class="ScrollCarousel">
                                <div class="ScrollCarousel-Items m--margin-top-20"></div>
                                <div class="whiteShadow"></div>
                            </div>
                            <div class="text-center showVideoMessage"></div>
                        </div>
                        <div class="tab-pane" id="m_tabs_pamphlet" role="tabpanel">
                            <div class="ScrollCarousel">
                                <div class="ScrollCarousel-Items m--margin-top-20"></div>
                                <div class="whiteShadow"></div>
                            </div>
                            <div class="text-center showPamphletMessage"></div>
                        </div>
                    </div>
                    <div class="setStepProgressBar"></div>
                </div>
            </div>
        </div>
    </div>
@endif
