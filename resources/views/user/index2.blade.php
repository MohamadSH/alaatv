@foreach($users as $user)
        <tr id="{{$user->id}}">
        <td>
            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                <input type="checkbox" class="checkboxes" value="1" />
                <span></span>
            </label>
        </td>
        <td id="userFullName_{{$user->id}}">@if(isset($user->firstName) && strlen($user->firstName)>0 || isset($user->lastName) && strlen($user->lastName)>0) @if(isset($user->firstName) && strlen($user->firstName)>0) {{ $user->firstName}} @endif @if(isset($user->lastName) && strlen($user->lastName)>0) {{$user->lastName}} @endif @else <span class="label label-sm label-danger"> کاربر ناشناس </span> @endif</td>
        <td >@if(isset($user->major->id) && strlen($user->major->name)>0 ) {{$user->major->name}} @else <span class="label label-sm label-warning"> درج نشده </span> @endif</td>
        <td>
            <span class="bold">شماره شخصی:</span>
            @if(isset($user->mobile) && strlen($user->mobile)>0) {{ $user->mobile}} @else <span class="label label-sm label-danger"> درج نشده </span> @endif
            <br>
            @if(!$user->contacts->isEmpty())
                @foreach($user->contacts as $contact)
                    @if(isset($contact->relative->id))
                        @if(strcmp($contact->relative->name,'father') == 0)
                            {!! Form::hidden('fatherNumbers', $contact->phones->where("phonetype_id" , 1)->count(), ['id' => 'fatherNumbers'.$user->id]) !!}
                            <span class="bold">شماره پدر</span><br>
                            @if(!$contact->phones->isEmpty())
                                @foreach($contact->phones as $phone)
                                    {{$phone->phonetype->displayName}} : {{$phone->phoneNumber}}
                                    <br>
                                @endforeach
                            @else <span class="label label-sm label-info">بدون شماره</span>

                            @endif
                        @elseif(strcmp($contact->relative->name,'mother') == 0)
                            {!! Form::hidden('motherNumbers', $contact->phones->where("phonetype_id" , 1)->count(), ['id' => 'motherNumbers'.$user->id]) !!}
                            <span class="bold">شماره مادر</span><br>
                            @if(!$contact->phones->isEmpty())
                                @foreach($contact->phones as $phone)
                                    {{$phone->phoneNumber}}
                                    <br>
                                @endforeach
                            @else  <span class="label label-sm label-info">بدون شماره</span>
                            @endif
                        @endif
                    @endif
                @endforeach
            @endif
        </td>
        <td>@if(isset($user->mobileNumberVerification) && $user->mobileNumberVerification == 1) <span class="label label-sm label-success">احراز هویت کرده</span> @else <span class="label label-sm label-danger"> نامعتبر </span> @endif</td>
        <td>@if(isset($user->nationalCode) && strlen($user->nationalCode)>0) {{ $user->nationalCode }} @else <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($user->city) && strlen($user->city)>0) {{ $user->city }} @else <span class="label label-sm label-warning"> درج نشده </span> @endif</td>
    </tr>
@endforeach