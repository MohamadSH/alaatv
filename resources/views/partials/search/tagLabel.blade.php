@foreach($tags as $key=>$tag)
        <span class="tag label label-info" style="margin: 2px">
            <a class="removeTagLabel" data-role="{{$key}}" style="padding-left: 10px"><i class="fa fa-remove"></i></a>
            <span id="tag_{{$key}}">
                <a href="{{urldecode(action("HomeController@search" , ["tags"=>[$tag]]))}}" class="font-white">{{$tag}}</a>
            </span>
            <input id="tagInput_{{$key}}" name="tags[]" type="hidden" value="{{$tag}}" >
        </span>
@endforeach
