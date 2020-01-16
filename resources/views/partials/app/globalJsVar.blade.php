<input id="js-var-userIp" class="m--hide" type="hidden" value='{{ $userIpAddress }}'>
<input id="js-var-userId" class="m--hide" type="hidden" value='{{ optional(Auth::user())->id }}'>
<input id="js-var-loginActionUrl" class="m--hide" type="hidden" value='{{ action('Auth\LoginController@login') }}'>
