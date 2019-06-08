@extends('app')

@section('page-css')
    <link href="{{ mix('/css/page-landing7.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .m-portlet__head {
            background: white;
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
                <div class="m-portlet__body">
                    <div class="m-widget27 m-portlet-fit--sides">
                        <div class="m-widget27__container">
                            <div class="container-fluid m--padding-right-40 m--padding-left-40">

                                <div class="row">
                                    <div class="col text-center">
                                        <h3 class="text-center">
                                           <span
                                                    class="m--font-primary">👈دبیرستان دانشگاه صنعتی شریف در سال 1383 تاسیس و زیر نظر دانشگاه صنعتی شریف فعالیت خود را آغاز کرد. فعالیت های آموزشی آلاء با نظارت دبیرستان دانشگاه شریف انجام می شود.👉</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            @if($sharifStudents->count() > 0)
                                <div class="row ">
                                    <div class="col">
                                        <h3 class="m-portlet__head-text">فارغ التحصیلان دانشگاه
                                            شریف</h3>
                                        @foreach($sharifStudents as $userKey => $user)
                                            <img class="m--image-center" src="{{ $user->photo }}?w=50&h=50"
                                                 alt="{{ $user->full_name }}"/>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($amirKabirStudents->count() > 0)
                                <div class="row ">
                                    <div class="col">
                                        <h3 class="m-portlet__head-text">فارغ التحصیلان دانشگاه
                                            امیر کبیر</h3>
                                        @foreach($amirKabirStudents as $userKey => $user)
                                            <img class="m--image-center" src="{{ $user->photo }}?w=50&h=50" alt="{{ $user->full_name }}" />
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($tehranStudents->count() > 0)
                                <div class="row ">
                                    <div class="col">
                                        <h3 class="m-portlet__head-text">فارغ التحصیلان دانشگاه تهران
                                            </h3>
                                        @foreach($tehranStudents as $userKey => $user)
                                            <img class="m--image-center" src="{{ $user->photo }}?w=50&h=50"
                                                 alt="{{ $user->full_name }}"/>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($beheshtiStudents->count() > 0)
                                <div class="row ">
                                    <div class="col">
                                        <h3 class="m-portlet__head-text">فارغ التحصیلان دانشگاه شهید
                                            بهشتی</h3>
                                        @foreach($beheshtiStudents as $userKey => $user)
                                            <img class="m--image-center" src="{{ $user->photo }}?w=50&h=50"
                                                 alt="{{ $user->full_name }}"/>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/page-shop.js') }}"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/components/aSticky/aSticky.js') }}"></script>
@endsection
