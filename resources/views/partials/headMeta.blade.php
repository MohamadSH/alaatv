
{!! Meta::tag('robots') !!}

{!! Meta::tag('site_name', 'آلاء') !!}

{!! Meta::tag('url', Request::url()); !!}

@if(!empty(Meta::get('canonical')))

    {!! Meta::tag('canonical') !!}

@endif

{!! Meta::tag('locale', 'fa_IR') !!}

{!! Meta::tag('keywords') !!}

{!! Meta::tag('description' , $wSetting->site->seo->homepage->metaDescription) !!}


@if(isset($wSetting->site->titleBar))

    {!! Meta::tag('title',$wSetting->site->titleBar) !!}

@elseif(isset($wSetting->site->name))

    {!! Meta::tag('title',$wSetting->site->name) !!}

@else

    {!! Meta::tag('title', "صفحه سایت") !!}

@endif

@if(empty(Meta::get('image')))

    {!! Meta::tag('image', route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $wSetting->site->siteLogo ])) !!}

@else
    {!! Meta::tag('image') !!}

@endif

