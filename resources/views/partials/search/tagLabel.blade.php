@foreach($tags as $key=>$tag)
    <span class="tag label label-info">
                <a class="removeTagLabel" data-role="{{$key}}"><i class="fa fa-remove"></i></a>
                <span id="tag_{{$key}}">{{$tag}}</span>
                <input id="tagInput_{{$key}}" name="tags[]" type="hidden" value="{{$tag}}" >
    </span>
@endforeach
