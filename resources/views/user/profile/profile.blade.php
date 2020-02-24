@extends('partials.templatePage' , ['pageName' => 'profile'])

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#"> پروفایل</a>
            </li>
        </ol>
    </nav>
@endsection

@section('page-css')
    <link href = "{{ mix('/css/user-profile.css') }}" rel = "stylesheet" type = "text/css"/>
@endsection

@section('content')

    <div class = "row">
        <div class = "col">
            {{--            Using this notification for some text at the top of the profile page        --}}
            {{--            @include("user.profile.topNotification")--}}

            {{--@include("user.profile.lotteryNotification" , [                                                            "userPoints"=>$userPoints ,--}}
            {{--"lotteryName"=>$lotteryName ,--}}
            {{--"exchangeAmount" => $exchangeAmount ,--}}
            {{--"userLottery" => $userLottery ,--}}
            {{--"prizeCollection" => $prizeCollection,--}}
            {{--"lotteryMessage" => $lotteryMessage,--}}
            {{--"lotteryRank" => $lotteryRank,--}}
            {{--])--}}
        </div>
    </div>

    <div class = "row">
        <div class = "col-md-3">
            <!-- BEGIN PROFILE SIDEBAR -->
        @include('partials.profileSidebar',[
                                        'user'=>$user ,
                                        'withInfoBox'=>true ,
                                        'withCompletionBox'=>true ,
                                        'withRegisterationDate'=>true,
                                        'withNavigation' => true,
                                        'withPhotoUpload' => true ,
                                          ]
                                          )
        <!-- END BEGIN PROFILE SIDEBAR -->
        </div>
        <div class = "col-md-9">
            @if($pageType === 'profile')
                @if(!$user->lockProfile)
                    @include('user.profile.profileEditView' , [
                    "withBio"=>true ,
                    "withBirthdate"=>false ,
                    "withIntroducer"=>false ,
                    "text2"=>"کاربر گرامی ، پس از تکمیل تمام اطلاعات پروفایل شما قفل شده و امکان اصلاح اطلاعات وجود نخواهد داشت. لذا خواهشمند هستیم این اطلاعات را در صحت و دقت تکمیل کنید."
                    ])
                @else
                    @include('user.profile.profileView', ['withBio'=>true])
                @endif
            @elseif($pageType === 'sabteRotbe')
                @include('user.profile.profileSabteRotbe')
            @endif
        </div>
    </div>
@endsection

@section('page-js')
    <script src = "{{ mix('/js/user-profile.js') }}"></script>
@endsection
