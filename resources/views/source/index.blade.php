<table class="table table-striped table-bordered table-hover dt-responsive" width="100%">
    <thead>
    <tr>
        <th></th>
        <th class="all"> نام</th>
        <th class="all"> لینک</th>
        <th class="all"> عکس</th>
        <th class="all"> عملیات</th>
    </tr>
    </thead>
    <tbody>
    @if($sources->isEmpty())
        <tr>
            <td colspan="4">
                اطلاعاتی برای نمایش وجود ندارد
            </td>
        </tr>
    @else
        @foreach( $sources as $source)
            <tr>
                <th></th>
                <td>
                    @if(isset($source->title))
                        {{$source->title}}
                    @else
                        <span class="m-badge m-badge--danger m-badge--wide">ندارد</span>
                    @endif
                </td>
                <td>
                    @if(isset($source->link))
                        <a target="_blank" href="{{$source->link}}">{{$source->link}}</a>
                    @else
                        <span class="m-badge m-badge--danger m-badge--wide">ندارد</span>
                    @endif
                </td>
                <td>
                    @if(isset($source->photo))
                        <a target="_blank" href="{{$source->photo}}">
                            <img width="200" height="100" src="{{$source->photo}}"
                                 alt="{{(isset($source->title))?$source->title:'عکس منبع'}}">
                        </a>
                    @else
                        <span class="m-badge m-badge--danger m-badge--wide">ندارد</span>
                    @endif
                </td>
                <td>
                    <a class="btn btn-success" target="_blank" href="{{route('source.edit' , $source)}}">اصلاح</a>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
