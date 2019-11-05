<div class="m-list-badge m--margin-bottom-10">
    @if(!isset($inlineTags))
        <div class="m-list-badge__label m--font-brand">تگ ها</div>
    @endif
    
    
    @if(!empty($tags))
        @foreach($tags as $key=>$tag)
            <span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-left-10 {{(isset($spanClass))?$spanClass:""}} tag_{{$key}}">
                @if(isset($withCloseIcon) && $withCloseIcon)
                    <a class="m-link removeTagLabel m--padding-right-10" data-role="{{$key}}"><i class="fa fa-times"></i></a>
                @endif
                    <a class="m-link m--font-light" href="{{urldecode(action("Web\ContentController@index" , ["tags"=>[$tag]]))}}">{{preg_replace('/_/', ' ', $tag)}}</a>
                @if(isset($withInput) && $withInput)
                    <input class="m--hide" id="tagInput_{{$key}}" name="tags[]" type="hidden" value="{{$tag}}">
                @endif
            </span>
        @endforeach
    @endif
</div>