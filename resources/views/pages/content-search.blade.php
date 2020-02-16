@extends('partials.templatePage',['pageName'=> $pageName ])

@section('page-css')
    <link href="{{ mix('/css/content-search.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="row showSearchBoxBtnWrapper">
        <div class="col showSearchBoxBtnWrapperColumn">
            <button class="btn btn-outline-accent btn-lg m-btn m-btn--icon m-btn--outline-2x btnShowSearchBoxInMobileView">
                <span>
                    <span>جستجوی پیشرفته</span>
                    <i class="fa fa-sliders-h m--padding-left-5"></i>
                </span>
            </button>
        </div>
    </div>

    <div class="row SearchColumnsWrapper">
        <div class="SearchBoxFilterColumn filterStatus-close">
            <div class="SearchBoxFilterColumn-tools">
                <button class="btn btn-outline-danger m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill m-btn--air m-btn--outline-2x btnHideSearchBoxInMobileView">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
                <button class="btn btn-outline-accent m-btn m-btn--air m-btn--outline-2x float-left btnApplyFilterInMobileView"> اعمال فیلتر </button>
            </div>
            <div class="SearchBoxFilter">

            </div>
        </div>
        <div class="searchResultColumn">

            <div class="row">
                <div class="col pageTags">
                    @include('partials.search.tagLabel' , ['tags'=>$tags, 'withCloseIcon'=>true, 'withInput'=>true])
                </div>
            </div>

            <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-warning alert-dismissible fade show notFoundMessage" role="alert">
                <div class="m-alert__icon">
                    <i class="fa fa-sad-tear"></i>
                    <span></span>
                </div>
                <div class="m-alert__text">
                    <strong>متاسفیم!</strong> با توجه به خواسته شما موردی یافت نشد.
                </div>
                <div class="m-alert__close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>

            <div class="searchResult">
                <div class="carouselType">
                    <div class="ScrollCarousel">
                        <div class="ScrollCarousel-Items">

                        </div>
                    </div>
                </div>

                <div class="listType">


                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')
    <script>
        var contentData = {!! json_encode($viewData) !!};
        var tags = {!! json_encode($tags) !!};
        var contentSearchApi = window.location.origin + '/api/v2/search';
    </script>
    <script src="{{ mix('/js/content-search.js') }}"></script>
@endsection
