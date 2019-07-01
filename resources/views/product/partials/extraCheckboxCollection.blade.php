@if(optional($product->attributes)->get('extra') !== null)
    @foreach(optional($product->attributes->get('extra'))->where('control', 'checkBox') as $checkboxArray)

        <label class = "m-checkbox m-checkbox--air m-checkbox--state-success">
            <input type = "checkbox" name = "extraAttribute[]" value = "{{ $checkboxArray->data[0]->id }}">
            {{ $checkboxArray->data[0]->name }}
            <span></span>
        </label>

    @endforeach
@endif
