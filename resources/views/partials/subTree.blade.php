<li><a href="#">{{ $category->name }}</a>
    @if($category->children->count() > 0)
        <ul>
            @each('partials.subTree', $category->children, 'category')
            {{--<li><a href="#">Branch</a></li>
            <li><a href="#">Branch</a>
                <ul>
                    <li><a href="#">Stick</a></li>
                    <li><a href="#">Stick</a></li>
                </ul>
            </li>--}}
        </ul>
    @endif
</li>