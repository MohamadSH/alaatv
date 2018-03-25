@if(isset($label)) <label class="col-md-2 bold control-label">{{$label}} </label> @endif
<label class="control-label" style="float: right;"><label class="mt-checkbox mt-checkbox-outline">
        <input type="checkbox" id="{{(isset($id))?$id:""}}CreatedTimeEnable" value="1" name="createdTimeEnable" @if(isset($default)) checked @endif>
        <span class="bg-grey-cararra"></span>
    </label>
</label>
<label class="control-label" style=" float: right;"   >از تاریخ
</label>
<div class="col-md-3 col-xs-12">
    <input id="{{(isset($id))?$id:""}}CreatedSince" type="text" class="form-control" @if(!isset($default)) disabled="disabled" @endif>
    <input name="createdSinceDate" id="{{(isset($id))?$id:""}}CreatedSinceAlt" type="text" class="form-control hidden" >
</div>
<label class="control-label" style="float: right;">تا تاریخ
</label>
<div class="col-md-3 col-xs-12">
    <input id="{{(isset($id))?$id:""}}CreatedTill" type="text" class="form-control" @if(!isset($default)) disabled="disabled" @endif>
    <input name="createdTillDate" id="{{(isset($id))?$id:""}}CreatedTillAlt" type="text" class="form-control hidden" >
</div>
