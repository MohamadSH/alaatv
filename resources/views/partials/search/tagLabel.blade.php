<div class = "m-list-badge m--margin-bottom-10">
    @if(!isset($inlineTags))
        <div class = "m-list-badge__label m--font-brand">تگ ها</div>
    @endif
    <div class = "m-list-badge__items">
        @if(!empty($tags))
            @foreach($tags as $key=>$tag)
                <span class = "m-list-badge__item m-list-badge__item--focus m--padding-10 m--margin-top-5 m--block-inline {{(isset($spanClass))?$spanClass:""}} tag_{{$key}}">
                    @if(isset($withCloseIcon)  && $withCloseIcon)
                        <a class = "m-link removeTagLabel m--padding-left-10" data-role = "{{$key}}"><i class = "fa fa-remove"></i></a>
                    @endif
                        <a class = "m-link m--font-light" href = "{{urldecode(action("Web\ContentController@index" , ["tags"=>[$tag]]))}}">{{$tag}}</a>
                    @if(isset($withInput) && $withInput)
                        <input class = "m--hide" id = "tagInput_{{$key}}" name = "tags[]" type = "hidden" value = "{{$tag}}">
                    @endif
                </span>
            @endforeach
        @endif
    </div>
</div>