@extends('app')

@section('page-css')
    <link href="{{ asset('/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css') }}?v=1" rel="stylesheet" type="text/css"/>
    <style>
        .m-portlet__head {
            background: white;
        }
        .m-portlet.m-portlet--head-overlay > .m-portlet__body.sharifLandingBody {
            margin-top: 0;
        }
        .a--owl-carousel-type-2 .owl-stage-outer .owl-stage .owl-item .m-widget_head-owlcarousel-item.carousel {
            margin-top: 31px;
            margin-bottom: 0px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">

                <div>
                    <img src="https://alaatv.com/image/9/1280/500/BIG-SLIDE-5_20190604170740.jpg" class="a--full-width">
                </div>
                <div class="m-portlet__body sharifLandingBody">
                    <div class="m-widget27 m-portlet-fit--sides">
                        <div class="m-widget27__container">
                            <div class="container-fluid m--padding-right-40 m--padding-left-40">

                                <div class="row">
                                    <div class="col text-center">
                                        <h3 class="text-center">
                                           <span
                                            class="m--font-primary">
                                               دبیرستان دانشگاه صنعتی شریف در سال 1383 تاسیس و زیر نظر دانشگاه صنعتی شریف فعالیت خود را آغاز کرد.
                                               <br>
                                               فعالیت های آموزشی آلاء با نظارت دبیرستان دانشگاه شریف انجام می شود.
                                           </span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            @if($sharifStudents->count() > 0)
                                @include('user.partials.owl-carousel.widget1', [
                                    'customClass' => 'faregotahsil faregotahsil-sharif',
                                    'customId' => 'faregotahsil-sharif',
                                    'users' => $sharifStudents,
                                    'title' => 'پذیرفته شدگان دانشگاه صنعتی شریف',
                                ])
                            @endif
                            @if($amirKabirStudents->count() > 0)
                                @include('user.partials.owl-carousel.widget1', [
                                    'customClass' => 'faregotahsil faregotahsil-amirKabir',
                                    'customId' => 'faregotahsil-amirKabir',
                                    'users' => $amirKabirStudents,
                                    'title' => 'پذیرفته شدگان دانشگاه امیر کبیر',
                                ])
                            @endif
                            @if($tehranStudents->count() > 0)
                                @include('user.partials.owl-carousel.widget1', [
                                    'customClass' => 'faregotahsil faregotahsil-tehran',
                                    'customId' => 'faregotahsil-tehran',
                                    'users' => $tehranStudents,
                                    'title' => 'پذیرفته شدگان دانشگاه تهران',
                                ])
                            @endif
                            @if($beheshtiStudents->count() > 0)
                                @include('user.partials.owl-carousel.widget1', [
                                    'customClass' => 'faregotahsil faregotahsil-beheshti',
                                    'customId' => 'faregotahsil-beheshti',
                                    'users' => $beheshtiStudents,
                                    'title' => 'پذیرفته شدگان دانشگاه شهید بهشتی',
                                ])
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js') }}"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/components/aSticky/aSticky.js') }}"></script>
    <script>
        $('.faregotahsil').each(function(){
            $(this).OwlCarouselType2({
                OwlCarousel: {
                    responsive: {
                        0: {
                            items: 1
                        },
                        400: {
                            items: 2
                        },
                        600: {
                            items: 4
                        },
                        800: {
                            items: 6
                        },
                        1000: {
                            items: 7
                        }
                    }
                },
                grid: {
                    columnClass: 'col-6 col-sm-4 col-md-2 gridItem'
                },
                defaultView: 'OwlCarousel', // OwlCarousel or grid
                childCountHideOwlCarousel: 4
            });
        });

        $('.faregotahsil').each(function(){
            var itemId = $(this).attr('id');
            $('#'+itemId+' .m-portlet__head').sticky({
                container: '#'+itemId+' > .col > .m-portlet',
                topSpacing: $('#m_header').height(),
                zIndex: 98
            });
        });

    </script>
@endsection
