@if(isset($img) and isset($link))
    <div class = "clearfix"></div>
    <div class = "row margin-top-20 margin-bottom-10">
        <div class = "col-md-12">
            <a href = "{{$link}}">
                <img src = "{{ $img }}" alt = "همایش های آلاء" class = "img-responsive" style = "width: 100%;">
            </a>
        </div>
    </div>
@endif

