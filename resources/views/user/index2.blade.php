@foreach($items as $item)
    <tr id="{{$item->id}}">
        <td>
            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                <input type="checkbox" class="checkboxes" value="1"/>
                <span></span>
            </label>
        </td>
        <td id="userFullName_{{$item->id}}">@if(isset($item->firstName) && strlen($item->firstName)>0 || isset($item->lastName) && strlen($item->lastName)>0) @if(isset($item->firstName) && strlen($item->firstName)>0) {{ $item->firstName}} @endif @if(isset($item->lastName) && strlen($item->lastName)>0) {{$item->lastName}} @endif @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> کاربر ناشناس </span> @endif</td>
        <td>@if(isset($item->major->id) && strlen($item->major->name)>0 ) {{$item->major->name}} @else <span
                    class="m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif</td>
        <td>
            <span class="bold">شماره شخصی:</span>
            @if(isset($item->mobile) && strlen($item->mobile)>0) {{ $item->mobile}} @else <span
                    class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif
            <br>
            @if(!$item->contacts->isEmpty())
                @foreach($item->contacts as $contact)
                    @if(isset($contact->relative->id))
                        @if(strcmp($contact->relative->name,'father') == 0)
                            {!! Form::hidden('fatherNumbers', $contact->phones->where("phonetype_id" , 1)->count(), ['id' => 'fatherNumbers'.$item->id]) !!}
                            <span class="bold">شماره پدر</span><br>
                            @if(!$contact->phones->isEmpty())
                                @foreach($contact->phones as $phone)
                                    {{$phone->phonetype->displayName}} : {{$phone->phoneNumber}}
                                    <br>
                                @endforeach
                            @else <span class="m-badge m-badge--wide label-sm m-badge--info">بدون شماره</span>

                            @endif
                        @elseif(strcmp($contact->relative->name,'mother') == 0)
                            {!! Form::hidden('motherNumbers', $contact->phones->where("phonetype_id" , 1)->count(), ['id' => 'motherNumbers'.$item->id]) !!}
                            <span class="bold">شماره مادر</span><br>
                            @if(!$contact->phones->isEmpty())
                                @foreach($contact->phones as $phone)
                                    {{$phone->phoneNumber}}
                                    <br>
                                @endforeach
                            @else  <span class="m-badge m-badge--wide label-sm m-badge--info">بدون شماره</span>
                            @endif
                        @endif
                    @endif
                @endforeach
            @endif
        </td>
        <td>@if($item->hasVerifiedMobile()) <span class="m-badge m-badge--wide label-sm m-badge--success">احراز هویت کرده</span> @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> نامعتبر </span> @endif</td>
        <td>@if(isset($item->nationalCode) && strlen($item->nationalCode)>0) {{ $item->nationalCode }} @else <span
                    class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($item->city) && strlen($item->city)>0) {{ $item->city }} @else <span
                    class="m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif</td>
    </tr>
@endforeach