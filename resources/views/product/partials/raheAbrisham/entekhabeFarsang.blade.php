<div class="alert alert-danger m--padding-30 m--margin-bottom-5 selectEntekhabeFarsangVideoAndPamphlet" role="alert">
    <div class="row">
        <div class="col-md-6">
            <p class="display-6 m--marginless">
                اگر الآن می خوای فرسنگ هارو ببینی، پس انتخابش کن
            </p>
        </div>
        <div class="col-md-6">
            <div class="CustomDropDown" id="selectFarsang">
                <select>
                    @foreach($sets as $setItem)
                        <option value="{{$setItem->id}}" @if($lastSet->id===$setItem->id) selected @endif>{{$setItem->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="m-portlet entekhabeFarsangVideoAndPamphlet">
            <div class="m-portlet__body">
                <div class="closeBtn">
                    <a href="#" data-toggle="m-tooltip" data-placement="top" data-original-title="مشاهده تمام فیلم ها و جزوات" >
                        <i class="fa fa-share-square m--font-danger btnShowMoreContents"></i>
                    </a>
                </div>
                <div class="sectionFilterCol">
                    <div class="sectionFilter-item">تابلو راهنما</div>
                    <div class="sectionFilter-item">تورق</div>
                    <div class="sectionFilter-item">حل تست</div>
                    <div class="sectionFilter-item">کنکورچه</div>
                    <div class="sectionFilter-item">پیش آزمون</div>
                </div>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#m_tabs_video">فیلم ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#m_tabs_pamphlet">جزوات</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="m_tabs_video" role="tabpanel">
                        <div class="ScrollCarousel">

                            <div class="ScrollCarousel-Items m--margin-top-20"></div>
                            <div class="whiteShadow"></div>

                        </div>
                        <div class="text-center showVideoMessage"></div>

                    </div>
                    <div class="tab-pane" id="m_tabs_pamphlet" role="tabpanel">
                        <div class="ScrollCarousel">
                            <div class="ScrollCarousel-Items m--margin-top-20"></div>
                            <div class="whiteShadow"></div>
                        </div>
                        <div class="text-center showPamphletMessage"></div>
                    </div>
                </div>
                <div class="farsangStepProgressBar"></div>
            </div>
        </div>
    </div>
</div>
