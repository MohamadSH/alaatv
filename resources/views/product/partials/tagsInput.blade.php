@if(isset($tags))
    <div class="row">
        <label class="col-md-2 control-label" for="tags">
            تگ ها :
        </label>
        <div class="col-md-9">
            <input name="tags" type="text" class="form-control input-large productTags" value="{{$tags}}">
        </div>
    </div>
@endif