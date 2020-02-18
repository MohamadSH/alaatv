{{ Form::hidden('js-var-userIp', $userIpAddress) }}
{{ Form::hidden('js-var-userId', optional(Auth::user())->id) }}
{{ Form::hidden('js-var-loginActionUrl', action('Auth\LoginController@login')) }}
{{ Form::hidden('js-var-firebaseConfig', json_encode(config('firebaseConfig.FIREBASE_CONFIG'))) }}
{{ Form::hidden('js-var-AlaaAdBanner', json_encode([
            'image'=> [
                'srcDeskTop'=> '/acm/image/adBanner/DeskTop.jpg',
                'srcTablet'=> '/acm/image/adBanner/Tablet.jpg',
                'srcMobile'=> '/acm/image/adBanner/Mobile.jpg',
                'alt'=> 'تخفیف 50 درصدی روز مادر تا سپندارمذگان',
                'widthDeskTop'=> '1948',
                'widthTablet'=> '1024',
                'widthMobile'=> '800',
                'heightDeskTop'=> '121',
                'heightTablet'=> '115',
                'heightMobile'=> '153'
            ],
            'tooltip'=> [
                'placement'=> 'bottom',
                'title'=> 'تا 50% تخفیف روی تمامی محصولات'
            ],
            'gtmEec'=> [
                'id'=> 'AlaaAdBanner-topOfMenu',
                'name'=> 'تخفیف 50 درصدی روز مادر تا سپندارمذگان',
                'creative'=> 'همه صفحات',
                'position'=> 'بالای صفحه'
            ],
            'link'=> [
                'href'=> action("Web\ShopPageController"),
                'target'=> '_self'
            ],
        ])) }}
