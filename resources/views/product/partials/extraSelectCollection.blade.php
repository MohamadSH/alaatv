@if(isset($extraSelectCollection) )
    @foreach($extraSelectCollection as $index => $select)
        <div class="col-md-12">
                <span class="sale-info"> {{ $select["attributeDescription"] }}
                    <i class="fa fa-img-up"></i>
                </span>
        </div>
        @if(isset($withExtraCost))
            <div class="col-md-6">
                {!! Form::select('extraAttribute[]',$select["attributevalues"] ,(isset($defaultExtraAttributes) && !empty(array_intersect($defaultExtraAttributes,array_flip($select["attributevalues"]))))?current(array_intersect($defaultExtraAttributes,array_flip($select["attributevalues"]))):null
                ,['class' => 'form-control extraAttribute selectExtraAttribute' , 'id'=>'selectExtraAttribute_'.$index]) !!}
            </div>
            <div class="col-md-6">
                {!! Form::text('', (isset($defaultExtraAttributes) && isset($select["extraCost"][current(array_intersect($defaultExtraAttributes,array_flip($select["attributevalues"])))]))?$select["extraCost"][current(array_intersect($defaultExtraAttributes,array_flip($select["attributevalues"])))]:null, ['class' => 'form-control' , 'id'=>'extraCost_'.$index , 'dir' => 'ltr' , 'placeholder'=>'قیمت افزوده به تومان']) !!}
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        @else
            <div class="col-md-12">
                {!! Form::select('extraAttribute[]',$select["attributevalues"] ,(isset($defaultExtraAttributes) && !empty(array_intersect($defaultExtraAttributes,array_flip($select["attributevalues"]))))?current(array_intersect($defaultExtraAttributes,array_flip($select["attributevalues"]))):null
                ,['class' => 'form-control extraAttribute selectExtraAttribute' , 'id'=>'selectExtraAttribute_'.$index]) !!}
            </div>
        @endif

    @endforeach
@endif