<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lottery extends Model
{
    use SoftDeletes;

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'displayName',
        'holdingDate',
        'essentialPoints',
        'prizes',
    ];

    public function users()
    {
        return $this->belongsToMany("\App\User")->withPivot("rank", "prizes");
    }

    public function prizes($rank)
    {
        $prizeName = "" ;
        $amount = 0;
        $memorial = "";
        if($this->id == 4)
        {
            if($rank==1)
            {//nafare aval
                $prizeName = "یک دستگاه پلی استیشن 4";
            }
//            else
//            {
//                $memorial = "کد تخفیف ayft با 70 درصد تخفیف";
//            }

//            elseif($rank > 13 && $rank <= 123 )
//            {
//                $amount = 60000 ;
//                $prizeName = "مبلغ ".number_format($amount). " تومان اعتبار هدیه";
//            }
        }
        return [
            $prizeName,
            $amount,
            $memorial
            ];
    }
}
