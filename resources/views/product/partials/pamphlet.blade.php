@if($product->samplePhotos != null)

    <div class = "m-portlet m-portlet--bordered m-portlet--creative m-portlet--bordered-semi m--margin-top-25">
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

            <div class = "m-scrollable m-scroller ps ps--active-y" data-scrollable = "true" style = "height: 200px; overflow: hidden;">

                <style>
                    .a--imageWithCaption {
                        cursor: pointer;
                    }

                    .a--imageWithCaption img {

                    }

                    .a--imageWithCaption .a--imageCaptionWarper {
                        width: 100%;
                        position: absolute;
                        z-index: 2;
                        height: 100%;
                        top: 0px;
                        left: 0px;
                        display: table;
                        background-color: #ff9000;
                        opacity: 0;
                        -webkit-transition: opacity .35s ease-out;
                        transition: opacity .35s ease-out;
                    }

                    .a--imageWithCaption .a--imageCaptionWarper .a--imageCaptionContent {
                        display: table-cell;
                        vertical-align: middle;
                        text-align: center;
                    }

                    .a--imageWithCaption .a--imageCaptionTitle {
                        position: relative;
                        bottom: 70px;
                        opacity: 0;
                        -webkit-transition: bottom .35s ease-out, opacity .35s ease-out;
                        transition: bottom .35s ease-out, opacity .35s ease-out;
                    }

                    .a--imageWithCaption .a--imageCaptionDescription {
                        position: relative;
                        opacity: 0;
                        top: 70px;
                        -webkit-transition: top .35s ease-out, opacity .35s ease-out;
                        transition: top .35s ease-out, opacity .35s ease-out;
                    }

                    .a--imageWithCaption:hover .a--imageCaptionTitle {
                        bottom: 0px;
                    }

                    .a--imageWithCaption:hover .a--imageCaptionDescription {
                        top: 0px;
                    }

                    .a--imageWithCaption:hover .a--imageCaptionTitle,
                    .a--imageWithCaption:hover .a--imageCaptionDescription {
                        opacity: 1;
                        color: white;
                        font-weight: bold;
                        font-size: medium;
                    }

                    .a--imageWithCaption:hover .a--imageCaptionWarper {
                        opacity: 0.9;
                    }

                    .lg-slide {
                        direction: ltr;
                    }
                </style>

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