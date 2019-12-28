<div class="alert alert-danger m--padding-30 m--margin-bottom-5 selectEntekhabeFarsangVideoAndPamphlet" role="alert">
    <div class="row">
        <div class="col-md-6">
            <p class="display-6 m--marginless">
                اگر الآن می خوای فرسنگ هارو ببینی، پس انتخابش کن
            </p>
        </div>
        <div class="col-md-6">
            <div class="CustomDropDown" id="selectFarsang">
                <select>
                    @foreach($sets as $setItem)
                        <option value="{{$setItem->id}}" @if($lastSet->id===$setItem->id) selected @endif>{{$setItem->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="m-portlet entekhabeFarsangVideoAndPamphlet">
            <div class="m-portlet__body">
                <div class="closeBtn">
                    <a href="#" data-toggle="m-tooltip" data-placement="top" data-original-title="مشاهده تمام فیلم ها و جزوات" >
                        <button type="button" class="btn m-btn--pill btn-outline-danger btnShowMoreContents">
                            <i class="fa fa-reply"></i>
                        </button>
                    </a>
                </div>
                <div class="sectionFilterCol">
                    <div class="sectionFilter-item">تابلو راهنما</div>
                    <div class="sectionFilter-item">تورق</div>
                    <div class="sectionFilter-item">حل تست</div>
                    <div class="sectionFilter-item">کنکورچه</div>
                    <div class="sectionFilter-item">پیش آزمون</div>
                </div>
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

                            <div class="ScrollCarousel-Items m--margin-top-20">

{{--                                @foreach($lastSetVideos as $item)--}}
{{--                                    <div class="item w-55443211">--}}
{{--                                        <a href="{{$item->url}}">--}}
{{--                                            <img class="lazy-image a--full-width"--}}
{{--                                                 src="https://cdn.alaatv.com/loder.jpg?w=16&h=9"--}}
{{--                                                 data-src="{{$item->thumbnail}}"--}}
{{--                                                 alt="samplePhoto"--}}
{{--                                                 width="253" height="142">--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}

{{--                                <div class="item w-55443211">--}}
{{--                                    <img class="lazy-image a--full-width"--}}
{{--                                         src="https://cdn.alaatv.com/loder.jpg?w=16&h=9"--}}
{{--                                         data-src="/acm/image/raheAbrisham/samplePhoto.png"--}}
{{--                                         alt="samplePhoto"--}}
{{--                                         width="253" height="142">--}}
{{--                                </div>--}}
                            </div>
                            <div class="whiteShadow"></div>

                        </div>
                        <div class="text-center showVideoMessage"></div>
                        <div class="farsangStepProgressBar"></div>

                    </div>
                    <div class="tab-pane" id="m_tabs_pamphlet" role="tabpanel">
                        <div class="ScrollCarousel">
                            <div class="ScrollCarousel-Items m--margin-top-20">
{{--                                @foreach($lastSetPamphlets as $item)--}}
{{--                                    <div class="item w-55443211">--}}
{{--                                        <a href="#">--}}
{{--                                            <div class="pamphletItem">--}}
{{--                                                <div class="pamphletItem-thumbnail">--}}
{{--                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">--}}
{{--                                                        <path style="fill:#F4A14E;" d="M512,256c0,19.508-2.184,38.494-6.311,56.738c-6.416,28.348-17.533,54.909-32.496,78.817  c-0.637,1.024-1.285,2.048-1.943,3.072C425.681,465.251,346.3,512,256,512S86.319,465.251,40.751,394.627  c-19.822-30.699-33.249-65.912-38.4-103.769c-1.191-8.735-1.933-17.617-2.215-26.624C0.042,261.496,0,258.759,0,256  c0-24.9,3.553-48.964,10.177-71.722c2.654-9.101,5.799-17.993,9.415-26.645c5.862-14.106,12.967-27.564,21.159-40.26  C86.319,46.749,165.7,0,256,0s169.681,46.749,215.249,117.373c10.365,16.06,18.986,33.353,25.59,51.618  c3.124,8.673,5.81,17.565,8.004,26.645c2.111,8.714,3.772,17.607,4.953,26.645c1.16,8.746,1.86,17.638,2.111,26.645  C511.969,251.277,512,253.628,512,256z"/>--}}
{{--                                                        <path style="fill:#F9EED7;" d="M471.249,127.76v266.867C425.681,465.251,346.3,512,256,512S86.319,465.251,40.751,394.627V22.8  c0-12.591,10.209-22.8,22.8-22.8h279.939L471.249,127.76z"/>--}}
{{--                                                        <path style="fill:#E8DBC4;" d="M343.489,104.958V0l127.76,127.76H366.291C353.698,127.76,343.489,117.551,343.489,104.958z"/>--}}
{{--                                                        <path style="fill:#FF525D;" d="M471.249,330.961v63.666C425.681,465.251,346.3,512,256,512S86.319,465.251,40.751,394.627v-63.666  L471.249,330.961L471.249,330.961z"/>--}}
{{--                                                        <path style="fill:#5C5E70;" d="M157.375,292.967c-3.474,0-6.921-0.547-10.187-1.678c-8.463-2.934-13.871-9.302-14.841-17.473  c-1.317-11.103,5.306-29.586,44.334-54.589c11.285-7.229,22.837-12.976,34.413-17.492c1.162-2.198,2.351-4.438,3.558-6.711  c8.945-16.848,19.331-36.411,27.596-55.402c-15.258-30.061-21.671-58.182-21.671-66.936c0-15.46,8.68-27.819,20.639-29.387  c4.811-0.632,21.117-0.425,28.887,28.714c4.785,17.942-1.38,41.91-11.673,66.958c2.814,5.151,5.964,10.429,9.479,15.702  c7.666,11.499,16.328,22.537,25.247,32.441c37.765,0.227,67.003,9.163,74.427,13.943c10.572,6.809,14.857,18.342,10.662,28.7  c-5.549,13.703-20.603,15.948-31.812,13.707c-16.191-3.238-34.248-17.427-46.544-28.758c-4.367-4.024-8.712-8.328-12.978-12.842  c-18.743,0.422-41.758,3.244-65.516,11.696c-1.971,3.754-3.836,7.355-5.553,10.76c-2.391,5.244-21.103,45.772-33.678,58.348  C175.52,289.313,166.357,292.967,157.375,292.967z M200.593,222.43c-5.368,2.695-10.724,5.722-16.02,9.116  c-37.601,24.088-38,38.004-37.699,40.549c0.296,2.493,2.014,4.302,5.105,5.373c5.426,1.88,13.981,0.718,19.841-5.141  C180.051,264.094,193.9,236.627,200.593,222.43z M308.038,202.364c15.452,14.531,30.458,24.596,41.264,26.756  c9.163,1.835,14.013-1.469,15.385-4.854c1.497-3.698-0.474-7.981-5.025-10.91C355.383,210.602,335.446,204.274,308.038,202.364z   M251.13,155.566c-6.247,13.416-13.238,26.834-19.949,39.513c14.801-4.077,29.376-6.35,43.204-7.348  c-6.683-8.035-12.988-16.454-18.647-24.943C254.142,160.395,252.605,157.983,251.13,155.566z M243.624,57.773  c-0.172,0-0.342,0.01-0.508,0.032c-3.806,0.498-7.911,6.33-7.911,14.881c0,3.494,2.029,14.9,7.474,30.631  c1.746,5.042,4.037,11.087,6.957,17.737c6.246-17.614,9.422-33.685,6.332-45.271C252.619,63.225,247.458,57.773,243.624,57.773z"/>--}}
{{--                                                        <g>--}}
{{--                                                            <path style="fill:#F9EED7;" d="M135.128,366.165c0-3.319,3.053-6.239,7.7-6.239h27.479c17.523,0,31.328,8.231,31.328,30.532v0.664   c0,22.302-14.337,30.798-32.656,30.798h-13.142v28.673c0,4.248-5.177,6.372-10.355,6.372c-5.176,0-10.354-2.124-10.354-6.372   V366.165z M155.838,377.979v28.011h13.142c7.433,0,11.947-4.247,11.947-13.275v-1.46c0-9.027-4.513-13.275-11.947-13.275   L155.838,377.979L155.838,377.979z"/>--}}
{{--                                                            <path style="fill:#F9EED7;" d="M256.464,359.926c18.319,0,32.656,8.496,32.656,31.328v34.382c0,22.833-14.337,31.328-32.656,31.328   h-23.497c-5.442,0-9.027-2.921-9.027-6.239v-84.56c0-3.319,3.585-6.239,9.027-6.239L256.464,359.926L256.464,359.926z    M244.65,377.979v60.932h11.815c7.433,0,11.947-4.248,11.947-13.275v-34.382c0-9.027-4.513-13.275-11.947-13.275H244.65V377.979z"/>--}}
{{--                                                            <path style="fill:#F9EED7;" d="M315.541,366.297c0-4.247,4.513-6.372,9.027-6.372h46.064c4.38,0,6.239,4.646,6.239,8.894   c0,4.912-2.256,9.16-6.239,9.16h-34.381v22.435h20.045c3.983,0,6.239,3.85,6.239,8.098c0,3.584-1.858,7.833-6.239,7.833h-20.045   v34.249c0,4.247-5.177,6.372-10.355,6.372c-5.176,0-10.354-2.124-10.354-6.372v-84.296H315.541z"/>--}}
{{--                                                        </g>--}}
{{--                                                    </svg>--}}
{{--                                                </div>--}}
{{--                                                <div class="pamphletItem-name">--}}
{{--                                                    جزوۀ عربی دهم- درس اول (قسمت اول)--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}

{{--                                <div class="item w-55443211">--}}
{{--                                    <img class="lazy-image a--full-width"--}}
{{--                                         src="https://cdn.alaatv.com/loder.jpg?w=16&h=9"--}}
{{--                                         data-src="/acm/image/raheAbrisham/samplePhoto.png"--}}
{{--                                         alt="samplePhoto"--}}
{{--                                         width="253" height="142">--}}
{{--                                </div>--}}
                            </div>
                            <div class="whiteShadow"></div>

                        </div>
                        <div class="text-center showPamphletMessage"></div>
{{--                        <div class="text-center m--margin-top-10">--}}
{{--                            <a href="#">--}}
{{--                                <button type="button" class="btn m-btn--pill btn-outline-danger btnShowMorePamphlet">مشاهده تمام جزوات</button>--}}
{{--                            </a>--}}
{{--                        </div>--}}
                        <div class="farsangStepProgressBar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
