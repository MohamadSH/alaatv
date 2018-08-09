<p ><i class="fa fa-location-arrow font-yellow-gold" aria-hidden="true"></i>
    <strong class="font-yellow-gold">استان: </strong><span class="bold"> {{$user->province}}</span>
</p>
<p ><i class="fa fa-location-arrow font-yellow-gold" aria-hidden="true"></i>
    <strong  class="font-yellow-gold">شهر: </strong><span class="bold"> {{$user->city}}</span>
</p>
<p ><i class="fa fa-map-marker font-yellow-gold" aria-hidden="true"></i>
    <strong  class="font-yellow-gold">آدرس محل سکونت: </strong><span class="bold"> {{$user->address}}</span>
</p>
<p ><i class="fa fa-envelope-open font-yellow-gold" aria-hidden="true"></i>
    <strong  class="font-yellow-gold">کد پستی: </strong><span class="bold"> {{$user->postalCode}}</span>
</p>
<p ><i class="fa fa-user font-yellow-gold" aria-hidden="true"></i>
    <strong  class="font-yellow-gold">جنیست: </strong><span class="bold">@if(isset($user->gender)) {{$user->gender->name}} @else <span class="label label-danger">درج نشده</span>  @endif</span>
</p>
<p ><i class="fa fa-graduation-cap font-yellow-gold" aria-hidden="true"></i>
    <strong  class="font-yellow-gold">تاریخ تولد: </strong><span class="bold">@if(isset($user->birthdate)) {{$user->Birthdate_Jalali()}} @else <span class="label label-danger">درج نشده</span>  @endif</span>
</p>
<p ><i class="fa fa-graduation-cap font-yellow-gold" aria-hidden="true"></i>
    <strong  class="font-yellow-gold">مدرسه: </strong><span class="bold">@if(isset($user->school)) {{$user->school}} @else <span class="label label-danger">درج نشده</span>  @endif</span>
</p>
<p ><i class="fa fa-graduation-cap font-yellow-gold" aria-hidden="true"></i>
    <strong  class="font-yellow-gold">رشته: </strong><span class="bold">@if(isset($user->major)) {{$user->major->name}} @else <span class="label label-danger">درج نشده</span>  @endif</span>
</p>
<p ><i class="fa fa-graduation-cap font-yellow-gold" aria-hidden="true"></i>
    <strong  class="font-yellow-gold">چگونه با آلاء آشنا شدید: </strong><span class="bold">@if(isset($user->introducedBy)) {{$user->introducedBy}} @else <span class="label label-danger">درج نشده</span>  @endif</span>
</p>
<p><i class="fa fa-envelope-o font-yellow-gold" aria-hidden="true"></i>
    <strong  class="font-yellow-gold">ایمیل: </strong><span class="bold"> @if(isset($user->email)){{$user->email}} @else <span class="label label-danger">درج نشده</span> @endif</span>
</p>