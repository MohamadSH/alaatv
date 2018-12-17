@permission((Config::get('constants.LIST_QUESTION_ACCESS')))
@if(isset($pageName) && strcmp($pageName , "consultantAdmin") == 0)
    @foreach($questions as $question)
        <div class="item">
            <div class="item-head">
                <div class="item-details">
                    <img class="item-pic"
                         @if(strlen($question->user->photo)>0) src="{{ route('image', ['category'=>'1','w'=>'30' , 'h'=>'30' ,  'filename' => $question->user->photo ]) }}"
                         alt="عکس پروفایل" @endif>
                    <a href="{{action("UseruploadController@show" , $question)}}"
                       class="item-name primary-link">@if(isset($question->user->id)) @if(isset($question->user->firstName) && strlen($question->user->firstName)>0 || isset($question->user->lastName) && strlen($question->user->lastName)>0) @if(isset($question->user->firstName) && strlen($question->user->firstName)>0) {{ $question->user->firstName}} @endif @if(isset($question->user->lastName) && strlen($question->user->lastName)>0) {{$question->user->lastName}} @endif @else
                            <span class="label label-sm label-danger"> کاربر ناشناس </span> @endif @endif</a>
                    <span class="item-label">پرسیده شده در {{$question->CreatedAt_Jalali()}}</span>
                </div>
                @if(strcmp($question->useruploadstatus->name , "pending") == 0)
                    <span class="item-status">
                            <span class="badge badge-empty badge-success"></span>جدید</span>
                @elseif(strcmp($question->useruploadstatus->name , "processing") == 0)
                    <span class="item-status">
                                                                    <span class="badge badge-empty badge-primary"></span> در حال بررسی</span>
                @elseif(strcmp($question->useruploadstatus->name , "done") == 0)
                    <span class="item-status">
                                                                    <span class="badge badge-empty badge-primary"></span> پاسخ داده شده</span>
                @endif
            </div>
            <div class="item-body">
                @if(isset($question->title)) {{$question->title}} @endif</div>
        </div>
    @endforeach
@else
    @foreach($questions as $question)
        <tr id="{{$question->id}}">
            <th></th>
            <td>@if(isset($question->user->id)) @if(strlen($question->user->reverse_full_name) > 0) <a
                        target="_blank"
                        href="{{action("UserController@edit" , $question->user)}}">{{$question->user->reverse_full_name}}</a> @else
                    <span class="label label-sm label-danger"> درج نشده </span> @endif @endif</td>
            <td>@if(strlen($question->title) > 0)  {{$question->title}} @else <span class="label label-sm label-danger">بدون عنوان </span> @endif
            </td>
            <td style="direction: ltr">
                <div id="jquery_jplayer_{{$counter}}" class="jp-jplayer"></div>
                <div id="jp_container_{{$counter}}" class="jp-audio-stream" role="application"
                     aria-label="media player">
                    <div class="jp-type-single">
                        <div class="jp-gui jp-interface">
                            <div class="jp-controls">
                                <button class="jp-play" role="button" tabindex="0">play</button>
                            </div>
                            <div class="jp-volume-controls">
                                <button class="jp-mute" role="button" tabindex="0">mute</button>
                                <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                <div class="jp-volume-bar">
                                    <div class="jp-volume-bar-value"></div>
                                </div>
                            </div>
                        </div>
                        <div class="jp-details">
                            <div class="jp-title" aria-label="title">&nbsp;</div>
                        </div>
                        <div class="jp-no-solution">
                            <span>Update Required</span>
                            To play the media you will need to either update your browser to a recent version or update
                            your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                        </div>
                    </div>
                </div>
            </td>
            <td style="text-align: center">@if(strlen($question->file) > 0)  <a target="_blank"
                                                                                href="{{action("HomeController@download" , ["content"=>"سؤال مشاوره ای","fileName"=>$question->file ])}}"
                                                                                id="link_{{$counter}}"
                                                                                class="btn btn-icon-only blue"><i
                            class="fa fa-download"></i></a>@else <span
                        class="label label-sm label-danger"> بدون فایل </span> @endif </td>
            <td style="width: 20%">
                {!! Form::model($question, ['method' => 'PUT', 'action' => ['UseruploadController@update', $question] , 'id' => 'useruploadForm_'.$question->id]) !!}
                <div class="input-group">
                    <div class="input-icon">
                        {!! Form::select('useruploadstatus_id', $questionStatuses, null, ['class' => 'form-control']) !!}
                    </div>
                    <span class="input-group-btn">
                                        <button type="submit" class="btn grey-mint useruploadUpdate">تأیید</button>
                                    </span>
                </div>
                {!! Form::close() !!}
            </td>
            <td>
                {{$question->CreatedAt_Jalali()}}
            </td>
        </tr>
        <script>
            $(document).ready(function () {
                var stream = {
                        //                    mp3: "http://listen.radionomy.com/abc-jazz"
                        mp3: $("#link_{{$counter}}").attr("href")
                    },
                    ready = false;

                $("#jquery_jplayer_{{$counter}}").jPlayer({
                    ready: function (event) {
                        ready = true;
                        $(this).jPlayer("setMedia", stream);
                    },
                    pause: function () {
                        $(this).jPlayer("clearMedia");
                    },
                    error: function (event) {
                        if (ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
                            // Setup the media stream again and play it.
                            $(this).jPlayer("setMedia", stream).jPlayer("play");
                        }
                    },
                    swfPath: "/acm/extra/jplayer/dist/jplayer",
                    cssSelectorAncestor: "#jp_container_{{$counter++}}",
                    supplied: "mp3",
                    preload: "none",
                    wmode: "window",
                    useStateClassSkin: true,
                    autoBlur: false,
                    keyEnabled: true
                });

            });
        </script>
    @endforeach
@endif
@endpermission

