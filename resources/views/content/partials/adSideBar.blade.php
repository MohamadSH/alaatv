@forelse( $items as $item)
    <div class="row margin-bottom-20">
        <div class="col-md-4">
            <a href="{{action("ContentController@show" , $item)}}">
                <img src="{{($item->files->where("pivot.label" , "thumbnail")->isNotEmpty())?$item->files->where("pivot.label" , "thumbnail")->first()->name."?w=99&h=56":"" }}" alt="{{isset($item->name[0]) ? $item->name : ''}}" width="100%">
            </a>
        </div>
        <div class="col-md-8">
            <a href="{{action("ContentController@show" , $item)}}">
                @if(isset($item->name[0])){{$item->name}}@else <span class="font-red">بدون عنوان</span> @endif
            </a>
        </div>
    </div>
@empty
@endforelse