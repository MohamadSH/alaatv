@if(isset($pageName))
    <ul class="feeds">
    @foreach($articles as $article)
        <!-- TIMELINE ITEM -->
        {{--<div class="timeline-item">--}}
            {{--<div class="timeline-badge">--}}
                {{--<img class="timeline-badge-userpic" src="{{ route('image', ['category'=>'8','w'=>'608' , 'h'=>'608' ,  'filename' =>  $article->image ]) }}" alt="عکس مقاله @if(strlen($article->title)>0) {{$article->title}} @endif" >--}}
                {{--<i class="fa fa-cogs fa-2x"></i>--}}
            {{--</div>--}}

            {{--<div class="timeline-body">--}}
                {{--<div class="timeline-body-arrow"> </div>--}}
                {{--<div class="timeline-body-head">--}}
                    {{--<div class="timeline-body-head-caption">--}}
                        {{--<a href="{{action("ArticleController@show", $article)}}" class="timeline-body-title font-blue-madison pull-left" >{{ $article->title }}</a>--}}
                        {{--<span class="timeline-body-time font-grey-cascade">{{$article->CreatedAt_Jalali()}}</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="timeline-body-content">--}}
                    {{--<span class="font-grey-cascade">{!! $article->brief !!}</span>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <li>
            <a href="{{action("ArticleController@show", $article)}}">
                <div class="col1">
                    <div class="cont">
                        <div class="cont-col1">
                            <div class="label label-sm label-danger">
                                <i class="fa fa-file-pdf-o"></i>
                            </div>
                        </div>
                        <div class="cont-col2">
                            <div class="desc">{{ $article->title }}</div>
                        </div>
                    </div>
                </div>
                <div class="col2">
                    <div class="date">{{$article->CreatedAt_Jalali()}}</div>
                </div>
            </a>
        </li>
        <!-- END TIMELINE ITEM -->
    @endforeach

    </ul>
@else
@permission((Config::get('constants.LIST_ARTICLE_ACCESS')))

@foreach( $articles as $article)
    <tr id="{{$article->id}}">
        <th></th>
        <td>@if(isset($article->title) && strlen($article->title)>0) <a href="{{action("ArticleController@show", $article->id)}}">{{ $article->title}}</a> @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        <td>
            <div class="mt-element-overlay">
                <div class="mt-overlay-1">
                    <img alt="عکس مقاله @if(isset($article->title[0])) {{$article->title}} @endif" class="timeline-badge-userpic" style="width: 60px ;height: 60px" src="{{ route('image', [ 'category'=>'8','w'=>'60' , 'h'=>'60' , 'filename' =>  $article->image ]) }}" />
                    <div class="mt-overlay">
                        <ul class="mt-info">
                            <li>
                                <a class="btn default btn-outline" data-toggle="modal" href="#articleImage-{{$article->id}}"><i class="icon-magnifier"></i></a>
                            </li>
                            <li>
                                <a target="_blank" class="btn default btn-outline" href="{{action("HomeController@download" , ["content"=>"عکس مقاله","fileName"=>$article->image ])}}">
                                    <i class="icon-link"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Image Modal -->
            <div id="articleImage-{{$article->id}}" class="modal fade" tabindex="-1" data-width="760">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">نمایش عکس مقاله</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="text-align: center;">
                        <img alt="عنوان مقاله @if(isset($article->title[0])) {{$article->title}} @endif"  style="width: 80%"  src="{{ route('image', ['category'=>'8','w'=>'608' , 'h'=>'608' ,  'filename' =>  $article->image ]) }}"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-outline dark">بستن</button>
                </div>
            </div>
        </td>
        <td>@if(isset($article->articlecategory_id) && strlen($article->articlecategory_id)>0) {{ $article->articlecategory->name}} @else <span class="label label-sm label-warning"> بدون دسته </span> @endif </td>
        <td>@if(isset($article->order)) {{ $article->order}} @else <span class="label label-sm label-danger"> بدون ترتیب </span> @endif </td>
        <td>@if(isset($article->brief) && strlen($article->brief)>0) {{ $article->brief}} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        <td>@if(isset($article->updated_at) && strlen($article->updated_at)>0) {{ $article->UpdatedAt_Jalali()}} @else <span class="label label-sm label-danger"> درج نشده </span> @endif </td>
        <td>
            <div class="btn-group">
                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> عملیات
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @permission((Config::get('constants.SHOW_ARTICLE_ACCESS')))
                    <li>
                        <a href="{{action("ArticleController@edit" , $article)}}">
                            <i class="fa fa-pencil"></i> اصلاح </a>
                    </li>
                    @endpermission
                    @permission((Config::get('constants.REMOVE_ARTICLE_ACCESS')))
                    <li>
                        <a data-target="#static-{{$article->id}}" data-toggle="modal">
                            <i class="fa fa-remove"></i> حذف </a>
                    </li>
                    @endpermission
                </ul>
                <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
                <!-- static -->
                @permission((Config::get('constants.REMOVE_ARTICLE_ACCESS')))
                <div id="static-{{$article->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-body">
                        <p> آیا مطمئن هستید؟ </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                        <button type="button" data-dismiss="modal"  class="btn green" onclick="removeArticle('{{action("ArticleController@destroy" , $article)}}');" >بله</button>
                    </div>
                </div>
                @endpermission
            </div>
        </td>
    </tr>
@endforeach
@endpermission
@endif