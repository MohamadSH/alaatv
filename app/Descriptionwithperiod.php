<?php

namespace App;

/**
 * @property mixed id
 * @property mixed till
 * @property mixed since
 */
class Descriptionwithperiod extends BaseModel
{
    protected $fillable = [
        'product_id',
        'staff_id',
        'description',
        'since',
        'till',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'period_start',
        'period_end',
    ];

    public function product()
    {
        return $this->belongsTo(Product::Class);
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    /**
     * Converting since field to Jalali
     *
     * @param bool $withTime
     *
     * @return string
     */
    public function Since_Jalali($withTime = false): string
    {
        $since            = $this->since;
        $explodedDateTime = explode(' ', $since);
        $explodedTime     = $explodedDateTime[1];
        $explodedDate     = $this->convertDate($since, 'toJalali');

        if ($withTime) {
            return ($explodedDate . ' ' . $explodedTime);
        } else {
            return $explodedDate . '';
        }
    }

    /**
     * Converting till field to Jalali
     *
     * @param bool $withTime
     *
     * @return string
     */
    public function Until_Jalali($withTime = false): string
    {
        $till             = $this->till;
        $explodedDateTime = explode(' ', $till);
        $explodedTime     = $explodedDateTime[1];
        $explodedDate     = $this->convertDate($till, 'toJalali');

        if ($withTime) {
            return ($explodedDate . ' ' . $explodedTime);
        } else {
            return $explodedDate . '';
        }
    }
}
