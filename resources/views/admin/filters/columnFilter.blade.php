<select class="mt-multiselect btn btn-default" multiple="multiple" data-width="100%" id="{{$id}}"
        title="انتخاب ستون های اصلی">
    @foreach($tableDefaultColumns as $column)
        <option value="{{$column}}">{{$column}}</option>
    @endforeach
</select>
