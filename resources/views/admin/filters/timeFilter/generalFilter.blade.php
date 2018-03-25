@if(isset($label)) <label class="col-md-2 bold control-label">{{$label}} </label> @endif
<label class="control-label" style="float: right;"><label class="mt-checkbox mt-checkbox-outline">
        <input type="checkbox" id="{{(isset($id))?$id:""}}{{(isset($enableId))?$enableId:""}}" value="1" name="{{(isset($enableId))?$enableId:""}}" @if(isset($default)) checked @endif>
        <span class="bg-grey-cararra"></span>
    </label>
</label>
<label class="control-label" style=" float: right;"   >از تاریخ
</label>
<div class="col-md-3 col-xs-12">
    <input id="{{(isset($id))?$id:""}}{{(isset($sinceDateId))?$sinceDateId:""}}" type="text" class="form-control" @if(!isset($default)) disabled="disabled" @endif>
    <input name="{{(isset($sinceDateId))?$sinceDateId:""}}" id="{{(isset($id))?$id:""}}{{(isset($sinceDateId))?$sinceDateId:""}}Alt" type="text" class="form-control hidden" >
</div>
<label class="control-label" style="float: right;">تا تاریخ
</label>
<div class="col-md-3 col-xs-12">
    <input id="{{(isset($id))?$id:""}}{{(isset($tillDateId))?$tillDateId:""}}" type="text" class="form-control" @if(!isset($default)) disabled="disabled" @endif>
    <input name="{{(isset($tillDateId))?$tillDateId:""}}" id="{{(isset($id))?$id:""}}{{(isset($tillDateId))?$tillDateId:""}}Alt" type="text" class="form-control hidden" >
</div>
