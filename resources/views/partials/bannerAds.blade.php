@if(isset($img) and isset($link))
    <div class="row margin-bottom-@if(isset($marginBottom)){{$marginBottom}}@endif" style="margin-top: 15px;">
        <div class="col-md-12">
            <div class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active" >
                        <a href="{{$link}}">
                            <img src="{{ $img }}" alt="همایش های آلاء" >
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

