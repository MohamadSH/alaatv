@extends('partials.barePage' , ['pageName' => ((isset($pageName)) ? $pageName : ''), 'bodyClass' => 'm-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-aside-right--enabled m-footer--push m-aside--offcanvas-default '.(isset($closedSideBar) && $closedSideBar ? 'm-aside-left--hide':'')])

@section('bare-page-head')
    @yield('page-head')
@endsection

@section('bare-page-body')

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <!-- BEGIN: Header -->
        @include('partials.app.header1')
        <!-- END: Header -->

        <!-- begin::Body -->
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

            @include('partials.app.sidebar')

            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <div class="m-content">
                    @yield('pageBar')

                    @include('systemMessage.flash')

                    @yield('content')
                </div>
            </div>

        </div>
        <!-- end:: Body -->

        @include('partials.app.footer1')

    </div>
    <!-- end:: Page -->

    @include('partials.app.quickSidebar')

    <!-- begin::Scroll Top -->
    <div id="m_scroll_top" class="m-scroll-top">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- end::Scroll Top -->

@endsection

@section('bare-page-js')
    @yield('page-js')
@endsection
