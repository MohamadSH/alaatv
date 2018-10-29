@forelse( $items as $item)
    <div class="row margin-bottom-20">
        <div class="col-md-4">
            <a href="{{action("ContentController@show" , $item)}}">
                <img src="{{ $item->thumbnail."?w=99&h=56" }}" alt="{{ $item->name }}" width="100%">
            </a>
        </div>
        <div class="col-md-8">
            <a href="{{action("ContentController@show" , $item)}}">
                {{ $item->name }}
            </a>
        </div>
    </div>
@empty
@endforelse