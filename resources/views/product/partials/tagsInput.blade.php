<div class="row">
    <label class="col-md-2 control-label" for="{{((isset($id))?$id:'tags')}}">
        {{(isset($label))?$label:'تگ ها :'}}
    </label>
    <div class="col-md-9">
        <input name="{{((isset($name))?$name:'tags')}}" type="text" class="form-control input-large productTags" value="{{(isset($value))?$value:''}}">
    </div>
</div>
