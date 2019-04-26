<div class = "row">
    @if(isset($label))
        <label class = "col-md-2 bold control-label">{{$label}} </label>
    @endif
    <label class = "control-label" style = "float: right;">
        <label class = "mt-checkbox mt-checkbox-outline">
            <input type = "checkbox" id = "{{$id}}CompletedTimeEnable" value = "1" name = "completedTimeEnable" @if(isset($default)) checked @endif>
            <span class = "bg-grey-cararra"></span>
        </label>
    </label>
    <label class = "control-label" style = " float: right;">از تاریخ
    </label>
    <div class = "col-md-3 col-xs-12">
        <input id = "{{$id}}CompletedSince" type = "text" class = "form-control" @if(!isset($default)) disabled = "disabled" @endif>
        <input name = "completedSinceDate" id = "{{$id}}CompletedSinceAlt" type = "text" class = "form-control d-none">
    </div>
    <label class = "control-label" style = "float: right;">تا تاریخ
    </label>
    <div class = "col-md-3 col-xs-12">
        <input id = "{{$id}}CompletedTill" type = "text" class = "form-control" @if(!isset($default)) disabled = "disabled" @endif>
        <input name = "completedTillDate" id = "{{$id}}CompletedTillAlt" type = "text" class = "form-control d-none">
    </div>
</div>
