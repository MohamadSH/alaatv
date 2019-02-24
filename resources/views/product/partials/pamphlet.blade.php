@if($product->samplePhotos != null)

    <div class = "m-portlet m-portlet--bordered m-portlet--creative m-portlet--bordered-semi m--margin-top-25 productPamphletWarper">
        <div class = "m-portlet__head">
            <div class = "m-portlet__head-caption col">
                <div class = "m-portlet__head-title">
                    <span class = "m-portlet__head-icon">
                        <i class = "flaticon-open-box"></i>
                    </span>
                    <h3 class = "m-portlet__head-text">
                        نمونه صفحات جزوه را مشاهده کنید:
                    </h3>
                    <h2 class = "m-portlet__head-label m-portlet__head-label--primary">
                        <span>نمونه جزوه</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class = "m-portlet__body m--padding-top-5 m--padding-bottom-5">

            <div class = "m-scrollable m-scroller ps ps--active-y productPamphletBody" data-scrollable = "true">
                <div class = "container-fluid">
                    <div class = "row" id = "lightgallery">
                        @foreach ($product->samplePhotos as $samplePhoto)
                            <div class = "col col-md-6 m--padding-left-5 m--padding-right-5 m--margin-top-5 a--imageWithCaption" data-src = "{{ $samplePhoto->url }}">
                                <img src = "{{ $samplePhoto->url  }}" alt = "{{ $samplePhoto->title }}" class = "img-thumbnail">
                                <div class = "a--imageCaptionWarper">
                                    <div class = "a--imageCaptionContent">
                                        <div class = "a--imageCaptionTitle">{{ isset($samplePhoto->title[0]) ? $samplePhoto->title : '--' }}</div>
                                        <div class = "a--imageCaptionDescription">{{ isset($samplePhoto->description) ? $samplePhoto->description : '--' }}</div>
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