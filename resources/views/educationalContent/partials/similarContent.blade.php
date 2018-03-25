@if($soonContentsWithSameType->isNotEmpty())
    <div class="mt-element-list">
        <div class="mt-list-head list-simple ext-1 font-white bg-blue-sharp">
            <div class="list-head-title-container">
                {{--<div class="list-date">Nov 8, 2015</div>--}}
                <h3 class="list-title">به زودی</h3>
            </div>
        </div>
        <div class="mt-list-container list-simple ext-1">
            <ul>
                @foreach($soonContentsWithSameType as $content)
                    <li class="mt-list-item">
                        <div class="list-icon-container">
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                        </div>
                        <div class="list-datetime"> @if($content->grades->isNotEmpty()){{$content->grades->first()->displayName}}@endif   </div>
                        <div class="list-item-content">
                            <h5 class="uppercase bold">
                                <a href="{{action("EducationalContentController@show" , $content)}}">{{$content->getDisplayName()}}</a>
                            </h5>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif