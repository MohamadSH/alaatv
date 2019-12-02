<style>
    .CustomSelect {
        border: solid 1px #a9a9a9;
        border-radius: 5px;
        padding: 5px;
    }
    .CustomSelect .CustomSelect-Item {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        background: transparent;
        transition: all 0.5s;
    }
    .CustomSelect .CustomSelect-Item:hover {
        background: #c6c6c8;
        color: white;
    }
    .CustomSelect .CustomSelect-Item.selected {
        background: #201f2b;
        color: white;
    }
</style>
@if(isset($items))
    <div class="CustomSelect">
        @foreach($items as $key=>$value)
            <div class="CustomSelect-Item @if(isset($value['selected']) && $value['selected']) selected @endif" data-value="{{ $value['value'] }}">
                {{ $value['name'] }}
            </div>
        @endforeach
    </div>
@endif
