{{ Form::hidden('js-var-userIp', $userIpAddress) }}
{{ Form::hidden('js-var-userId', optional(Auth::user())->id) }}
{{ Form::hidden('js-var-loginActionUrl', action('Auth\LoginController@login')) }}
{{ Form::hidden('js-var-firebaseConfig', json_encode(config('firebaseConfig.FIREBASE_CONFIG'))) }}
{{ Form::hidden('js-var-firebaseVapidKey', config('firebaseConfig.VAP_ID_KEY')) }}
