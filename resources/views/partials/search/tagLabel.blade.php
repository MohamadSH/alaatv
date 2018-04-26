@foreach($tags as $key=>$tag)
    <span class="tag label label-info" id="tag_{{$key}}" style="margin: 2px">
            @if(isset($withCloseIcon)  && $withCloseIcon)
                <a class="removeTagLabel" data-role="{{$key}}" style="padding-left: 10px"><i class="fa fa-remove"></i></a>
            @endif
            <span >
                <a href="{{urldecode(action("HomeController@search" , ["tags"=>[$tag]]))}}"
                   class="font-white">{{$tag}}</a>
            </span>
        @if(isset($withInput) && $withInput)
            <input id="tagInput_{{$key}}" name="tags[]" type="hidden"
                                                   value="{{$tag}}">
        @endif
    </span>
@endforeach
