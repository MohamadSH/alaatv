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
        if($rank==1)
        {//nafare aval
            $prizeName = "یک دستگاه آیفون X";
        }elseif($rank > 1 && $rank <= 6)
        {//5 nafare baadi
            $amount = 120000;
            $prizeName = "مبلغ ".number_format($amount). " تومان اعتبار هدیه";
        }elseif($rank > 6 && $rank <= 13 )
        {//7 nafare baadi
            $amount = 80000;
            $prizeName = "مبلغ ".number_format($amount). " تومان اعتبار هدیه";
        }elseif($rank > 13 && $rank <= 123 )
        {//110 nafare baadi
            $amount = 60000 ;
            $prizeName = "مبلغ ".number_format($amount). " تومان اعتبار هدیه";
        }elseif($rank > 123 && $rank <= 303 )
        {//180 nafare baadi
            $amount = 50000;
            $prizeName = "مبلغ ".number_format($amount). " تومان اعتبار هدیه";

        }
        elseif($rank > 303 && $rank <= 398 )
        {//59 nafare baadi
            $amount = 40000;
            $prizeName = "مبلغ ".number_format($amount). " تومان اعتبار هدیه";
        }
        elseif($rank > 398 && $rank <= 711 )
        {//313 nafare baadi
            $amount = 25000;
            $prizeName = "مبلغ ".number_format($amount). " تومان اعتبار هدیه";
        }

        return [
            $prizeName,
            $amount
            ];
    }
}
