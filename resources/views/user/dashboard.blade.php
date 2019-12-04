@extends('app' , ["pageName"=>$pageName])

@section('page-css')
{{--    <link href="{{ mix('/css/content-search.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ mix('/css/user-dashboard.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/AlaatvCustomFiles/css/page/user-dashboard.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/AlaatvCustomFiles/css/page/pages/content-search/searchResult.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item">
                <i class="fa fa-user"></i>
                <a class="m-link" href="{{ action("Web\UserController@show",[$user]) }}">@lang('page.Profile')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                داشبورد
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include('systemMessage.flash')


    <style>
        .btn-group-rounded button:first-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .btn-group-rounded button:last-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .CustomParentOptions.CustomDropDown {
            border: solid 1px #a9a9a9;
            border-radius: 10px;
            padding: 10px;
            margin-top: 20px;
        }
        .CustomParentOptions.CustomDropDown:before {
            content: ' ';
            border-right: solid 20px transparent;
            border-left: solid 20px transparent;
            border-bottom: solid 20px #a9a9a9;
            position: absolute;
            left: calc( 50% - 40px );
            top: -20px;
        }
        .CustomDropDown .select-items {
            border: none;
            background: transparent;
        }
        .CustomDropDown .select-items .select-item {
            margin-bottom: 5px;
            background: white;
            border-radius: 10px;
        }

        .setRow {
            display: flex;
            justify-content: space-between;
        }
        .setRow .setRow-label {

        }
        .setRow .setRow-action {
            width: 200px;
            display: flex;
            justify-content: space-between;
        }
        .setRow .setRow-action button {
            width: 95px;
            border-radius: 5px;
            padding: 5px;
        }

    </style>
    <div class="row m--margin-bottom-10">
        <div class="col text-center">
            <div class="btn-group m-btn-group btn-group-rounded" role="group" aria-label="...">
                <button type="button" class="btn btn-secondary">علاقه مندی ها</button>
                <button type="button" class="btn btn-warning">محصولات من</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-11 mx-auto text-center">
            <style>
                .sortingFilter {
                    width: max-content;
                    margin: 0 auto 10px auto;
                }
                .sortingFilter .sortingFilter-item {
                    display: inline-block;
                    margin-left: 10px;
                }
            </style>
            <div class="sortingFilter">
                <div class="sortingFilter-item title">
                    <span>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 56 56" xml:space="preserve" width="25">
                            <g>
                                <path d="M8,41.08V2c0-0.553-0.448-1-1-1S6,1.447,6,2v39.08C2.613,41.568,0,44.481,0,48c0,3.859,3.14,7,7,7s7-3.141,7-7   C14,44.481,11.387,41.568,8,41.08z M7,53c-2.757,0-5-2.243-5-5s2.243-5,5-5s5,2.243,5,5S9.757,53,7,53z"/>
                                <path d="M29,20.695V2c0-0.553-0.448-1-1-1s-1,0.447-1,1v18.632c-3.602,0.396-6.414,3.456-6.414,7.161s2.812,6.765,6.414,7.161V54   c0,0.553,0.448,1,1,1s1-0.447,1-1V34.891c3.4-0.577,6-3.536,6-7.098S32.4,21.272,29,20.695z M27.793,33   c-2.871,0-5.207-2.336-5.207-5.207s2.335-5.207,5.207-5.207S33,24.922,33,27.793S30.664,33,27.793,33z"/>
                                <path d="M56,8c0-3.859-3.14-7-7-7s-7,3.141-7,7c0,3.519,2.613,6.432,6,6.92V54c0,0.553,0.448,1,1,1s1-0.447,1-1V14.92   C53.387,14.432,56,11.519,56,8z M49,13c-2.757,0-5-2.243-5-5s2.243-5,5-5s5,2.243,5,5S51.757,13,49,13z"/>
                            </g>
                        </svg>
                    </span>
                    مرتب سازی بر اساس:
                </div>
                <div class="sortingFilter-item date">
                    @include('partials.CustomSelect', ['items'=>[
                            [
                                'name'=> 'جدید ترین ها',
                                'value'=> 'جدید ترین ها',
                                'selected'=> true
                            ],
                            [
                                'name'=> 'قدیمی ترین ها',
                                'value'=> 'قدیمی ترین ها',
                            ],
                        ]
                    ])
                </div>
                <div class="sortingFilter-item subject">
                    @include('partials.CustomSelect', ['items'=>[
                            [
                                'name'=> 'همه',
                                'value'=> 'همه',
                                'selected'=> true
                            ],
                            [
                                'name'=> 'همایش طلایی',
                                'value'=> 'همایش طلایی',
                            ],
                            [
                                'name'=> 'همایش گدار',
                                'value'=> 'همایش گدار'
                            ],
                            [
                                'name'=> 'همایش تفتان',
                                'value'=> 'همایش تفتان'
                            ],
                            [
                                'name'=> 'همایش راه ابریشم',
                                'value'=> 'همایش راه ابریشم'
                            ],
                        ]
                    ])
                </div>
            </div>
        </div>
    </div>
    <style>
        .myProductsRow {
            margin-bottom: 100px;
        }




        .productItem {
            background: white;
            margin-top: 10px;
        }
        .productItem .productItem-image {

        }
        .productItem .productItem-description {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .productItem .productItem-description .title {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .productItem .productItem-description .action {
            margin-top: 10px;
            width: 300px;
            display: flex;
            justify-content: space-between;
        }
        .productItem .productItem-description .action > .btn {
            width: 145px;
            border-radius: 5px;
            padding: 5px;
        }
        .productItem .productItem-description .action .CustomDropDown {
            width: 100%;
        }
    </style>
    <div class="row myProductsRow justify-content-center">
        <div class="col-md-5 productsCol">

            @foreach($userAssetsCollection as $userAssetKey=>$userAsset)
                @if($userAsset->title === 'محصولات من')
                    @foreach($userAsset->products as $productKey=>$product)

                        @include('user.partials.dashboard.productItem', [
                            'key'=> $productKey,
                            'name'=> $product->name,
                            'src'=> $product->photo,
                            'sets'=> $product->sets
                        ])

                    @endforeach
                @endif
            @endforeach


        </div>
        <style>
            .contentsetOfProductCol > .m-portlet > .m-portlet__body > .nav.nav-pills {
                background: #f2f3f8;
                border-radius: 5px;
            }
            .contentsetOfProductCol > .m-portlet > .m-portlet__body > .nav.nav-pills > .nav-item > .nav-link.active {
                background: #ffb822;
                color: black;
                border-radius: 5px;
            }
        </style>
        <div class="col-md-6 contentsetOfProductCol">


            <div class="m-portlet">

                <div class="m-portlet__body">
                    <ul class="nav nav-pills nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" data-toggle="tab" href="#searchResult_video">فیلم ها</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#searchResult_pamphlet">جزوات</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="searchResult_video" role="tabpanel">


                            <div class="searchResult">
                                <div class="listType">
                                    <div class="item ">
                                        <div class="pic">
                                            <a href="http://alaatv.test/c/16839" class="d-block">
                                                <img src="https://cdn.alaatv.com/media/thumbnails/548/548020mmhz.jpg?w=349&amp;h=195" data-src="https://cdn.alaatv.com/media/thumbnails/548/548020mmhz.jpg?w=444&amp;h=250" alt="فصل هشتم: تولید مثل نهان دانگان (قسمت اول)، گفتار 1: تولید مثل غیرجنسی" class="a--full-width lazy-image videoImage lazy-done" a-lazyload="1" data-loaded="true" width="253" height="142">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <div class="title">
                                                <h2>
                                                    <a href="http://alaatv.test/c/16839" class="m-link">
                                                        فصل هشتم: تولید مثل نهان دانگان (قسمت اول)، گفتار 1: تولید مثل غیرجنسی
                                                    </a>
                                                </h2>
                                            </div>
                                            <div class="detailes">
                                                <div class="videoDetaileWrapper">
                                                    <span>
                                                        <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon">
                                                            <path d="M3.67 8.67h14V11h-14V8.67zm0-4.67h14v2.33h-14V4zm0 9.33H13v2.34H3.67v-2.34zm11.66 0v7l5.84-3.5-5.84-3.5z" class="style-scope yt-icon"></path>
                                                        </svg>
                                                    </span>
                                                    <span> از دوره </span>
                                                    <span>کارگاه تست زیست یازدهم (نظام آموزشی جدید) (99-1398) جلال موقاری</span>
                                                    <br>
                                                    <i class="fa fa-calendar-alt m--margin-right-5"></i>
                                                    <span>تاریخ بروزرسانی: </span>
                                                    <span>۱۳۹۸/۰۶/۲۰ ۱۸:۵۹:۱۳</span>
                                                    <div class="videoOrder">
                                                        <div class="videoOrder-title">جلسه</div>
                                                        <div class="videoOrder-number">20</div>
                                                        <div class="videoOrder-om"> اُم </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="itemHover"></div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="videoContentNextPageUrl">

                        </div>
                        <div class="tab-pane" id="searchResult_pamphlet" role="tabpanel">


                            <div class="m-widget4">
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">

                                        <svg width="50" height="50" viewBox="-79 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m353.101562 485.515625h-353.101562v-485.515625h273.65625l79.445312 79.449219zm0 0" fill="#e3e4d8"/><path d="m273.65625 0v79.449219h79.445312zm0 0" fill="#d0cebd"/><path d="m0 353.101562h353.101562v158.898438h-353.101562zm0 0" fill="#b53438"/><g fill="#fff"><path d="m52.964844 485.515625c-4.871094 0-8.828125-3.953125-8.828125-8.824219v-88.277344c0-4.875 3.957031-8.828124 8.828125-8.828124 4.875 0 8.828125 3.953124 8.828125 8.828124v88.277344c0 4.871094-3.953125 8.824219-8.828125 8.824219zm0 0"/><path d="m300.136719 397.242188h-52.964844c-4.871094 0-8.828125-3.957032-8.828125-8.828126 0-4.875 3.957031-8.828124 8.828125-8.828124h52.964844c4.875 0 8.828125 3.953124 8.828125 8.828124 0 4.871094-3.953125 8.828126-8.828125 8.828126zm0 0"/><path d="m300.136719 441.378906h-52.964844c-4.871094 0-8.828125-3.953125-8.828125-8.828125 0-4.871093 3.957031-8.828125 8.828125-8.828125h52.964844c4.875 0 8.828125 3.957032 8.828125 8.828125 0 4.875-3.953125 8.828125-8.828125 8.828125zm0 0"/><path d="m247.171875 485.515625c-4.871094 0-8.828125-3.953125-8.828125-8.824219v-88.277344c0-4.875 3.957031-8.828124 8.828125-8.828124 4.875 0 8.828125 3.953124 8.828125 8.828124v88.277344c0 4.871094-3.953125 8.824219-8.828125 8.824219zm0 0"/></g><path d="m170.203125 95.136719c-.863281.28125-11.695313 15.261719.847656 27.9375 8.351563-18.371094-.464843-28.054688-.847656-27.9375m5.34375 73.523437c-6.296875 21.496094-14.601563 44.703125-23.527344 65.710938 18.378907-7.042969 38.375-13.195313 57.140625-17.546875-11.871094-13.621094-23.738281-30.632813-33.613281-48.164063m65.710937 57.175782c7.167969 5.445312 8.914063 8.199218 13.613282 8.199218 2.054687 0 7.925781-.085937 10.636718-3.828125 1.316407-1.820312 1.828126-2.984375 2.019532-3.59375-1.074219-.574219-2.515625-1.710937-10.335938-1.710937-4.449218 0-10.027344.191406-15.933594.933594m-119.957031 38.601562c-18.804687 10.425781-26.464843 19-27.011719 23.835938-.089843.804687-.328124 2.90625 3.785157 6.011718 1.316406-.414062 8.96875-3.859375 23.226562-29.847656m-23.421875 44.527344c-3.0625 0-6-.980469-8.507812-2.832032-9.15625-6.796874-10.390625-14.347656-9.808594-19.492187 1.597656-14.132813 19.304688-28.945313 52.648438-44.03125 13.230468-28.636719 25.820312-63.921875 33.324218-93.398437-8.773437-18.871094-17.3125-43.351563-11.097656-57.714844 2.179688-5.03125 4.910156-8.894532 9.976562-10.566406 2.011719-.652344 7.078126-1.480469 8.941407-1.480469 4.617187 0 9.050781 5.507812 11.183593 9.089843 3.972657 6.648438 3.992188 14.390626 3.363282 21.859376-.609375 7.253906-1.84375 14.46875-3.265625 21.601562-1.039063 5.242188-2.214844 10.460938-3.46875 15.660156 11.855469 24.175782 28.644531 48.816406 44.746093 65.683594 11.539063-2.054688 21.460938-3.097656 29.546876-3.097656 13.761718 0 22.121093 3.167968 25.519531 9.691406 2.828125 5.402344 1.660156 11.726562-3.433594 18.769531-4.898437 6.769531-11.640625 10.34375-19.523437 10.34375-10.710938 0-23.15625-6.671875-37.050782-19.851562-24.957031 5.15625-54.097656 14.34375-77.65625 24.515625-7.355468 15.410156-14.398437 27.824218-20.964844 36.933594-8.996093 12.5-16.773437 18.316406-24.472656 18.316406" fill="#b53438"/><path d="m79.449219 450.207031h-26.484375c-4.871094 0-8.828125-3.953125-8.828125-8.828125v-52.964844c0-4.875 3.957031-8.828124 8.828125-8.828124h26.484375c19.472656 0 35.308593 15.835937 35.308593 35.3125 0 19.472656-15.835937 35.308593-35.308593 35.308593zm-17.65625-17.65625h17.65625c9.734375 0 17.652343-7.917969 17.652343-17.652343 0-9.738282-7.917968-17.65625-17.652343-17.65625h-17.65625zm0 0" fill="#fff"/><path d="m158.898438 485.515625h-8.828126c-4.875 0-8.828124-3.953125-8.828124-8.824219v-88.277344c0-4.875 3.953124-8.828124 8.828124-8.828124h8.828126c29.199218 0 52.964843 23.753906 52.964843 52.964843 0 29.210938-23.765625 52.964844-52.964843 52.964844zm0-17.652344h.085937zm0-70.621093v70.621093c19.472656 0 35.308593-15.839843 35.308593-35.3125 0-19.472656-15.835937-35.308593-35.308593-35.308593zm0 0" fill="#fff"/></svg>

                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            Metronic Documentation
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">

                                        <svg width="50" height="50" viewBox="-79 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m353.101562 485.515625h-353.101562v-485.515625h273.65625l79.445312 79.449219zm0 0" fill="#e3e4d8"/><path d="m273.65625 0v79.449219h79.445312zm0 0" fill="#d0cebd"/><path d="m0 353.101562h353.101562v158.898438h-353.101562zm0 0" fill="#b53438"/><g fill="#fff"><path d="m52.964844 485.515625c-4.871094 0-8.828125-3.953125-8.828125-8.824219v-88.277344c0-4.875 3.957031-8.828124 8.828125-8.828124 4.875 0 8.828125 3.953124 8.828125 8.828124v88.277344c0 4.871094-3.953125 8.824219-8.828125 8.824219zm0 0"/><path d="m300.136719 397.242188h-52.964844c-4.871094 0-8.828125-3.957032-8.828125-8.828126 0-4.875 3.957031-8.828124 8.828125-8.828124h52.964844c4.875 0 8.828125 3.953124 8.828125 8.828124 0 4.871094-3.953125 8.828126-8.828125 8.828126zm0 0"/><path d="m300.136719 441.378906h-52.964844c-4.871094 0-8.828125-3.953125-8.828125-8.828125 0-4.871093 3.957031-8.828125 8.828125-8.828125h52.964844c4.875 0 8.828125 3.957032 8.828125 8.828125 0 4.875-3.953125 8.828125-8.828125 8.828125zm0 0"/><path d="m247.171875 485.515625c-4.871094 0-8.828125-3.953125-8.828125-8.824219v-88.277344c0-4.875 3.957031-8.828124 8.828125-8.828124 4.875 0 8.828125 3.953124 8.828125 8.828124v88.277344c0 4.871094-3.953125 8.824219-8.828125 8.824219zm0 0"/></g><path d="m170.203125 95.136719c-.863281.28125-11.695313 15.261719.847656 27.9375 8.351563-18.371094-.464843-28.054688-.847656-27.9375m5.34375 73.523437c-6.296875 21.496094-14.601563 44.703125-23.527344 65.710938 18.378907-7.042969 38.375-13.195313 57.140625-17.546875-11.871094-13.621094-23.738281-30.632813-33.613281-48.164063m65.710937 57.175782c7.167969 5.445312 8.914063 8.199218 13.613282 8.199218 2.054687 0 7.925781-.085937 10.636718-3.828125 1.316407-1.820312 1.828126-2.984375 2.019532-3.59375-1.074219-.574219-2.515625-1.710937-10.335938-1.710937-4.449218 0-10.027344.191406-15.933594.933594m-119.957031 38.601562c-18.804687 10.425781-26.464843 19-27.011719 23.835938-.089843.804687-.328124 2.90625 3.785157 6.011718 1.316406-.414062 8.96875-3.859375 23.226562-29.847656m-23.421875 44.527344c-3.0625 0-6-.980469-8.507812-2.832032-9.15625-6.796874-10.390625-14.347656-9.808594-19.492187 1.597656-14.132813 19.304688-28.945313 52.648438-44.03125 13.230468-28.636719 25.820312-63.921875 33.324218-93.398437-8.773437-18.871094-17.3125-43.351563-11.097656-57.714844 2.179688-5.03125 4.910156-8.894532 9.976562-10.566406 2.011719-.652344 7.078126-1.480469 8.941407-1.480469 4.617187 0 9.050781 5.507812 11.183593 9.089843 3.972657 6.648438 3.992188 14.390626 3.363282 21.859376-.609375 7.253906-1.84375 14.46875-3.265625 21.601562-1.039063 5.242188-2.214844 10.460938-3.46875 15.660156 11.855469 24.175782 28.644531 48.816406 44.746093 65.683594 11.539063-2.054688 21.460938-3.097656 29.546876-3.097656 13.761718 0 22.121093 3.167968 25.519531 9.691406 2.828125 5.402344 1.660156 11.726562-3.433594 18.769531-4.898437 6.769531-11.640625 10.34375-19.523437 10.34375-10.710938 0-23.15625-6.671875-37.050782-19.851562-24.957031 5.15625-54.097656 14.34375-77.65625 24.515625-7.355468 15.410156-14.398437 27.824218-20.964844 36.933594-8.996093 12.5-16.773437 18.316406-24.472656 18.316406" fill="#b53438"/><path d="m79.449219 450.207031h-26.484375c-4.871094 0-8.828125-3.953125-8.828125-8.828125v-52.964844c0-4.875 3.957031-8.828124 8.828125-8.828124h26.484375c19.472656 0 35.308593 15.835937 35.308593 35.3125 0 19.472656-15.835937 35.308593-35.308593 35.308593zm-17.65625-17.65625h17.65625c9.734375 0 17.652343-7.917969 17.652343-17.652343 0-9.738282-7.917968-17.65625-17.652343-17.65625h-17.65625zm0 0" fill="#fff"/><path d="m158.898438 485.515625h-8.828126c-4.875 0-8.828124-3.953125-8.828124-8.824219v-88.277344c0-4.875 3.953124-8.828124 8.828124-8.828124h8.828126c29.199218 0 52.964843 23.753906 52.964843 52.964843 0 29.210938-23.765625 52.964844-52.964843 52.964844zm0-17.652344h.085937zm0-70.621093v70.621093c19.472656 0 35.308593-15.839843 35.308593-35.3125 0-19.472656-15.835937-35.308593-35.308593-35.308593zm0 0" fill="#fff"/></svg>

                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            Metronic Documentation
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">

                                        <svg width="50" height="50" viewBox="-79 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m353.101562 485.515625h-353.101562v-485.515625h273.65625l79.445312 79.449219zm0 0" fill="#e3e4d8"/><path d="m273.65625 0v79.449219h79.445312zm0 0" fill="#d0cebd"/><path d="m0 353.101562h353.101562v158.898438h-353.101562zm0 0" fill="#b53438"/><g fill="#fff"><path d="m52.964844 485.515625c-4.871094 0-8.828125-3.953125-8.828125-8.824219v-88.277344c0-4.875 3.957031-8.828124 8.828125-8.828124 4.875 0 8.828125 3.953124 8.828125 8.828124v88.277344c0 4.871094-3.953125 8.824219-8.828125 8.824219zm0 0"/><path d="m300.136719 397.242188h-52.964844c-4.871094 0-8.828125-3.957032-8.828125-8.828126 0-4.875 3.957031-8.828124 8.828125-8.828124h52.964844c4.875 0 8.828125 3.953124 8.828125 8.828124 0 4.871094-3.953125 8.828126-8.828125 8.828126zm0 0"/><path d="m300.136719 441.378906h-52.964844c-4.871094 0-8.828125-3.953125-8.828125-8.828125 0-4.871093 3.957031-8.828125 8.828125-8.828125h52.964844c4.875 0 8.828125 3.957032 8.828125 8.828125 0 4.875-3.953125 8.828125-8.828125 8.828125zm0 0"/><path d="m247.171875 485.515625c-4.871094 0-8.828125-3.953125-8.828125-8.824219v-88.277344c0-4.875 3.957031-8.828124 8.828125-8.828124 4.875 0 8.828125 3.953124 8.828125 8.828124v88.277344c0 4.871094-3.953125 8.824219-8.828125 8.824219zm0 0"/></g><path d="m170.203125 95.136719c-.863281.28125-11.695313 15.261719.847656 27.9375 8.351563-18.371094-.464843-28.054688-.847656-27.9375m5.34375 73.523437c-6.296875 21.496094-14.601563 44.703125-23.527344 65.710938 18.378907-7.042969 38.375-13.195313 57.140625-17.546875-11.871094-13.621094-23.738281-30.632813-33.613281-48.164063m65.710937 57.175782c7.167969 5.445312 8.914063 8.199218 13.613282 8.199218 2.054687 0 7.925781-.085937 10.636718-3.828125 1.316407-1.820312 1.828126-2.984375 2.019532-3.59375-1.074219-.574219-2.515625-1.710937-10.335938-1.710937-4.449218 0-10.027344.191406-15.933594.933594m-119.957031 38.601562c-18.804687 10.425781-26.464843 19-27.011719 23.835938-.089843.804687-.328124 2.90625 3.785157 6.011718 1.316406-.414062 8.96875-3.859375 23.226562-29.847656m-23.421875 44.527344c-3.0625 0-6-.980469-8.507812-2.832032-9.15625-6.796874-10.390625-14.347656-9.808594-19.492187 1.597656-14.132813 19.304688-28.945313 52.648438-44.03125 13.230468-28.636719 25.820312-63.921875 33.324218-93.398437-8.773437-18.871094-17.3125-43.351563-11.097656-57.714844 2.179688-5.03125 4.910156-8.894532 9.976562-10.566406 2.011719-.652344 7.078126-1.480469 8.941407-1.480469 4.617187 0 9.050781 5.507812 11.183593 9.089843 3.972657 6.648438 3.992188 14.390626 3.363282 21.859376-.609375 7.253906-1.84375 14.46875-3.265625 21.601562-1.039063 5.242188-2.214844 10.460938-3.46875 15.660156 11.855469 24.175782 28.644531 48.816406 44.746093 65.683594 11.539063-2.054688 21.460938-3.097656 29.546876-3.097656 13.761718 0 22.121093 3.167968 25.519531 9.691406 2.828125 5.402344 1.660156 11.726562-3.433594 18.769531-4.898437 6.769531-11.640625 10.34375-19.523437 10.34375-10.710938 0-23.15625-6.671875-37.050782-19.851562-24.957031 5.15625-54.097656 14.34375-77.65625 24.515625-7.355468 15.410156-14.398437 27.824218-20.964844 36.933594-8.996093 12.5-16.773437 18.316406-24.472656 18.316406" fill="#b53438"/><path d="m79.449219 450.207031h-26.484375c-4.871094 0-8.828125-3.953125-8.828125-8.828125v-52.964844c0-4.875 3.957031-8.828124 8.828125-8.828124h26.484375c19.472656 0 35.308593 15.835937 35.308593 35.3125 0 19.472656-15.835937 35.308593-35.308593 35.308593zm-17.65625-17.65625h17.65625c9.734375 0 17.652343-7.917969 17.652343-17.652343 0-9.738282-7.917968-17.65625-17.652343-17.65625h-17.65625zm0 0" fill="#fff"/><path d="m158.898438 485.515625h-8.828126c-4.875 0-8.828124-3.953125-8.828124-8.824219v-88.277344c0-4.875 3.953124-8.828124 8.828124-8.828124h8.828126c29.199218 0 52.964843 23.753906 52.964843 52.964843 0 29.210938-23.765625 52.964844-52.964843 52.964844zm0-17.652344h.085937zm0-70.621093v70.621093c19.472656 0 35.308593-15.839843 35.308593-35.3125 0-19.472656-15.835937-35.308593-35.308593-35.308593zm0 0" fill="#fff"/></svg>

                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            Metronic Documentation
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--icon">

                                        <svg width="50" height="50" viewBox="-79 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m353.101562 485.515625h-353.101562v-485.515625h273.65625l79.445312 79.449219zm0 0" fill="#e3e4d8"/><path d="m273.65625 0v79.449219h79.445312zm0 0" fill="#d0cebd"/><path d="m0 353.101562h353.101562v158.898438h-353.101562zm0 0" fill="#b53438"/><g fill="#fff"><path d="m52.964844 485.515625c-4.871094 0-8.828125-3.953125-8.828125-8.824219v-88.277344c0-4.875 3.957031-8.828124 8.828125-8.828124 4.875 0 8.828125 3.953124 8.828125 8.828124v88.277344c0 4.871094-3.953125 8.824219-8.828125 8.824219zm0 0"/><path d="m300.136719 397.242188h-52.964844c-4.871094 0-8.828125-3.957032-8.828125-8.828126 0-4.875 3.957031-8.828124 8.828125-8.828124h52.964844c4.875 0 8.828125 3.953124 8.828125 8.828124 0 4.871094-3.953125 8.828126-8.828125 8.828126zm0 0"/><path d="m300.136719 441.378906h-52.964844c-4.871094 0-8.828125-3.953125-8.828125-8.828125 0-4.871093 3.957031-8.828125 8.828125-8.828125h52.964844c4.875 0 8.828125 3.957032 8.828125 8.828125 0 4.875-3.953125 8.828125-8.828125 8.828125zm0 0"/><path d="m247.171875 485.515625c-4.871094 0-8.828125-3.953125-8.828125-8.824219v-88.277344c0-4.875 3.957031-8.828124 8.828125-8.828124 4.875 0 8.828125 3.953124 8.828125 8.828124v88.277344c0 4.871094-3.953125 8.824219-8.828125 8.824219zm0 0"/></g><path d="m170.203125 95.136719c-.863281.28125-11.695313 15.261719.847656 27.9375 8.351563-18.371094-.464843-28.054688-.847656-27.9375m5.34375 73.523437c-6.296875 21.496094-14.601563 44.703125-23.527344 65.710938 18.378907-7.042969 38.375-13.195313 57.140625-17.546875-11.871094-13.621094-23.738281-30.632813-33.613281-48.164063m65.710937 57.175782c7.167969 5.445312 8.914063 8.199218 13.613282 8.199218 2.054687 0 7.925781-.085937 10.636718-3.828125 1.316407-1.820312 1.828126-2.984375 2.019532-3.59375-1.074219-.574219-2.515625-1.710937-10.335938-1.710937-4.449218 0-10.027344.191406-15.933594.933594m-119.957031 38.601562c-18.804687 10.425781-26.464843 19-27.011719 23.835938-.089843.804687-.328124 2.90625 3.785157 6.011718 1.316406-.414062 8.96875-3.859375 23.226562-29.847656m-23.421875 44.527344c-3.0625 0-6-.980469-8.507812-2.832032-9.15625-6.796874-10.390625-14.347656-9.808594-19.492187 1.597656-14.132813 19.304688-28.945313 52.648438-44.03125 13.230468-28.636719 25.820312-63.921875 33.324218-93.398437-8.773437-18.871094-17.3125-43.351563-11.097656-57.714844 2.179688-5.03125 4.910156-8.894532 9.976562-10.566406 2.011719-.652344 7.078126-1.480469 8.941407-1.480469 4.617187 0 9.050781 5.507812 11.183593 9.089843 3.972657 6.648438 3.992188 14.390626 3.363282 21.859376-.609375 7.253906-1.84375 14.46875-3.265625 21.601562-1.039063 5.242188-2.214844 10.460938-3.46875 15.660156 11.855469 24.175782 28.644531 48.816406 44.746093 65.683594 11.539063-2.054688 21.460938-3.097656 29.546876-3.097656 13.761718 0 22.121093 3.167968 25.519531 9.691406 2.828125 5.402344 1.660156 11.726562-3.433594 18.769531-4.898437 6.769531-11.640625 10.34375-19.523437 10.34375-10.710938 0-23.15625-6.671875-37.050782-19.851562-24.957031 5.15625-54.097656 14.34375-77.65625 24.515625-7.355468 15.410156-14.398437 27.824218-20.964844 36.933594-8.996093 12.5-16.773437 18.316406-24.472656 18.316406" fill="#b53438"/><path d="m79.449219 450.207031h-26.484375c-4.871094 0-8.828125-3.953125-8.828125-8.828125v-52.964844c0-4.875 3.957031-8.828124 8.828125-8.828124h26.484375c19.472656 0 35.308593 15.835937 35.308593 35.3125 0 19.472656-15.835937 35.308593-35.308593 35.308593zm-17.65625-17.65625h17.65625c9.734375 0 17.652343-7.917969 17.652343-17.652343 0-9.738282-7.917968-17.65625-17.652343-17.65625h-17.65625zm0 0" fill="#fff"/><path d="m158.898438 485.515625h-8.828126c-4.875 0-8.828124-3.953125-8.828124-8.824219v-88.277344c0-4.875 3.953124-8.828124 8.828124-8.828124h8.828126c29.199218 0 52.964843 23.753906 52.964843 52.964843 0 29.210938-23.765625 52.964844-52.964843 52.964844zm0-17.652344h.085937zm0-70.621093v70.621093c19.472656 0 35.308593-15.839843 35.308593-35.3125 0-19.472656-15.835937-35.308593-35.308593-35.308593zm0 0" fill="#fff"/></svg>

                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__text">
                                            Metronic Documentation
                                        </span>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <a href="#" class="m-widget4__icon">
                                            <i class="la la-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>




























        </div>
    </div>








    <div class="row blockWraper a--owl-carousel-row">
        <div class="col">
            <div class="m-portlet a--owl-carousel-Wraper" id="owlCarouselMyProduct">
                <div class="m-portlet__head a--owl-carousel-head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <span class="redSquare"></span>
                                محصولات خریداری شده من
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools d-none">
                        <a href="#"
                           class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewGrid"
                           title="نمایش شبکه ای">
                            <i class="fa fa-th"></i>
                        </a>
                        <a href="#"
                           class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewOwlCarousel"
                           title="نمایش افقی">
                            <i class="fa fa-exchange-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding a--owl-carousel-body">

                    @if($user->completion() < 60)
                        <div class="alert alert-warning" role="alert">
                            <strong>برای دانلود محصولات خریداری شده ، درصد تکمیل پروفایل شما باید حداقل 60 درصد
                                باشد </strong>
                            <a href="{{action('Web\UserController@show' , $user)}}"
                               class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">تکمیل
                                پروفایل</a>
                        </div>
                    @else

                        <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 myProduct">
                            @foreach($userAssetsCollection as $userAssetKey=>$userAsset)
                                @if($userAsset->title === 'محصولات من')
                                    @foreach($userAsset->products as $productKey=>$product)
                                        @include('block.partials.purchasedProducts')
                                    @endforeach
                                @endif
                            @endforeach
                        </div>

                        @if(count($userAssetsCollection->filter(function ($value, $key) {return $value->title === 'محصولات من'; })->all())===0)
                            <div class="alert alert-info" role="alert">
                                <strong> هنوز از آلاء خرید نکرده اید. </strong>
                                بعد از اینکه از آلاء خرید کنید، امکان مشاهده خریدهای شما در این قسمت فراهم می شود.
                            </div>
                        @endif

                        <div class="m-portlet a--owl-carousel-slide-detailes">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            مجموعه های محصول خریداری شده
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <a class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air a--owl-carousel-hide-detailes">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>

                            @foreach($userAssetsCollection as $userAssetKey=>$userAsset)
                                @if($userAsset->title === 'محصولات من')
                                    @foreach($userAsset->products as $productKey=>$product)
                                        @if(count($product->sets)>1)
                                            <div
                                                class="m-portlet__body subCategoryWarper a--owl-carousel-slide-iteDetail-{{ $productKey }}">
                                                <div class="row justify-content-center">
                                                    @foreach($product->sets as $setKey=>$set)
                                                        @if($set->getActiveContents2(config('constants.CONTENT_TYPE_PAMPHLET'))->isNotEmpty() || $set->getActiveContents2(config('constants.CONTENT_TYPE_VIDEO'))->isNotEmpty())
                                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                                <div class="subCategoryItem">
                                                                    <div class="subCategoryItem-title">
                                                                        {{ $set->name }}
                                                                    </div>
                                                                    <hr>
                                                                    <div
                                                                        class="m-btn-group m-btn-group--pill btn-group m-btn-group m-btn-group--pill btn-group-sm"
                                                                        role="group" aria-label="Small button group">
                                                                        @if($set->getActiveContents2(config('constants.CONTENT_TYPE_PAMPHLET'))->isNotEmpty())
                                                                            <button type="button"
                                                                                    class="btn btn-warning btnViewPamphlet"
                                                                                    data-content-type="pamphlet"
                                                                                    data-content-url="{{ $set->contentUrl.'&orderBy=order' }}">
                                                                                <i class="fa fa-edit"></i>
                                                                                جزوات
                                                                            </button>
                                                                        @endif
                                                                        @if($set->getActiveContents2(config('constants.CONTENT_TYPE_VIDEO'))->isNotEmpty())
                                                                            <button type="button"
                                                                                    class="btn btn-success btnViewVideo"
                                                                                    data-content-type="video"
                                                                                    data-content-url="{{ $set->contentUrl.'&orderBy=order' }}">
                                                                                <i class="fa fa-film"></i>
                                                                                فیلم ها
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>

    @foreach($userAssetsCollection as $userFavoritesKey=>$block)

        @if($block->title!=="محصولات من")

            @include('block.partials.block', [
                'blockCustomClass'=>$block->class.' userFavorites',
                'blockCustomId'=>'owlCarouselMyFavoritProducts',
                'blockType'=>'product',
                'blockTitle'=>'محصولات مورد علاقه من',
                'blockUrlDisable'=>false,
            ])

            @include('block.partials.block', [
                'blockCustomClass'=>$block->class.' userFavorites',
                'blockCustomId'=>'owlCarouselMyFavoritContent',
                'blockType'=>'content',
                'blockTitle'=>'فیلم های مورد علاقه من',
                'blockUrlDisable'=>false,
            ])

            @include('block.partials.block', [
                'blockCustomClass'=>$block->class.' userFavorites',
                'blockCustomId'=>'owlCarouselMyFavoritSet',
                'blockType'=>'set',
                'blockTitle'=>'مجموعه های مورد علاقه من',
                'blockUrlDisable'=>false,
            ])

        @endif
    @endforeach

    <!--begin::Modal-->
    <div class="modal fade" id="pamphletModal" tabindex="-1" role="dialog" aria-labelledby="pamphletModalModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pamphletModalModalLabel">
                        <i class="fa fa-edit"></i>
                        جزوات
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="m-widget6">
                                <div class="m-widget6__head">
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__caption">
                                            عنوان
                                        </span>
                                        <span class="m-widget6__caption">
                                            مشاهده / دانلود
                                        </span>
                                    </div>
                                </div>
                                <div class="m-widget6__body">

                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <input type="hidden" id="pamphletContentNextPageUrl">
                            <button type="button"
                                    class="btn m-btn m-btn--pill m-btn--air m-btn--gradient-from-info m-btn--gradient-to-warning btnLoadMoreInModal animated infinite heartBeat"
                                    data-content-type="pamphlet">
                                بیشتر ...
                            </button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade contentModal" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">
                        <i class="fa fa-film"></i>
                        فیلم ها
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="m-widget6">
                                <div class="m-widget6__head">
                                    <div class="m-widget6__item">
                                        <span class="m-widget6__caption">
                                            عنوان
                                        </span>
                                        <span class="m-widget6__caption">
                                            مشاهده / دانلود
                                        </span>
                                    </div>
                                </div>
                                <div class="m-widget6__body">

                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center">
{{--                            <input type="hidden" id="videoContentNextPageUrl">--}}
                            <button type="button"
                                    class="btn m-btn m-btn--pill m-btn--air m-btn--gradient-from-info m-btn--gradient-to-warning btnLoadMoreInModal animated infinite heartBeat"
                                    data-content-type="video">
                                بیشتر ...
                            </button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

@endsection

@section('page-js')
    <script src="{{ asset('/acm/AlaatvCustomFiles/components/CustomDropDown/js.js') }}"></script>
    <script src="{{ mix('/js/user-dashboard.js') }}"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/page/user/dashboard.js') }}"></script>
    <script>

        $('.CustomDropDown').CustomDropDown({
            onChange: function (data) {
                // console.log(data);
                // { index: 2, totalCount: 5, value: "3", text: "فرسنگ سوم" }
            },
            parentOptions: function ($this) {
                var parentId = $this.attr('data-parent-id');
                return '#'+parentId;
            },
            renderOption: function (label, value) {
                return '' +
                    '<div class="setRow">' +
                    '  <div class="setRow-label">'+
                        label+
                    '  </div>' +
                    '  <div class="setRow-action">'+
                    '    <button type="button"\n' +
                    '            class="btn btn-warning btnViewVideo"\n' +
                    '            data-content-type="video"\n' +
                    '            data-content-url="'+value+'">\n' +
                    '        فیلم ها\n' +
                    '    </button>\n' +
                    '    <button type="button"\n' +
                    '            class="btn btn-secondary"\n' +
                    '            data-content-type="pamphlet"\n' +
                    '            data-content-url="'+value+'">\n' +
                    '        جزوات\n' +
                    '    </button>'+
                    '  </div>' +
                    '</div>';
            }
        });

    </script>
@endsection
