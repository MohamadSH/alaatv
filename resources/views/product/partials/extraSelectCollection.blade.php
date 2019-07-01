@if(optional($product->attributes)->get('extra') !== null)
    @foreach(optional($product->attributes->get('extra'))->where('control', 'dropDown') as $dropdown)
        <div class = "form-group m-form__group">
            <label for = "exampleSelect1">{{ $dropdown->title }}</label>
            <select name = "extraAttribute[]" class = "form-control m-input attribute">
                @foreach($dropdown->data as $dropdownIndex => $dropdownOption)
                    <option value = "{{ $dropdownOption->id }}">{{ $dropdownOption->name }}</option>
                @endforeach
            </select>
        </div>
    @endforeach
@endif
