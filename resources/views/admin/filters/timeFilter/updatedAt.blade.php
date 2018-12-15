@if(isset($label)) <label class="col-md-2 bold control-label">{{$label}} </label> @endif
<label class="control-label" style="float: right;"><label class="mt-checkbox mt-checkbox-outline">
        <input type="checkbox" id="{{$id}}UpdatedTimeEnable" value="1" name="updatedTimeEnable"
               @if(isset($default)) checked @endif>
        <span class="bg-grey-cararra"></span>
    </label>
</label>
<label class="control-label" style=" float: right;">از تاریخ
</label>
<div class="col-md-3 col-xs-12">
    <input id="{{$id}}UpdatedSince" type="text" class="form-control" @if(!isset($default)) disabled="disabled" @endif>
    <input name="updatedAtSince" id="{{$id}}UpdatedSinceAlt" type="text" class="form-control hidden"
           @if(!isset($default)) disabled="disabled" @endif>
</div>
<label class="control-label" style="float: right;">تا تاریخ
</label>
<div class="col-md-3 col-xs-12">
    <input id="{{$id}}UpdatedTill" type="text" class="form-control" @if(!isset($default)) disabled="disabled" @endif>
    <input name="updatedAtTill" id="{{$id}}UpdatedTillAlt" type="text" class="form-control hidden"
           @if(!isset($default)) disabled="disabled" @endif>
</div>
