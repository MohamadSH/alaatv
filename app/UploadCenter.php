<?php

namespace App;

use App\Traits\DateTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UploadCenter extends Model
{
    use DateTrait;
    protected $table = 'uploadCenter';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'link',
    ];

    public function setCreatedAtAttribute($value):void
    {
        $this->attributes['created_at'] =  Carbon::parse($value)->setTimezone('Asia/Tehran')->format('Y-m-d H:i:s') ;
    }

    public function setUpdatedAtAttribute($value):void
    {
        $this->attributes['updated_at'] =  Carbon::parse($value)->setTimezone('Asia/Tehran')->format('Y-m-d H:i:s') ;
    }

    public function setDeletedAtAttribute($value):void
    {
        $this->attributes['deleted_at'] =  Carbon::parse($value)->setTimezone('Asia/Tehran')->format('Y-m-d H:i:s') ;
    }

    public function getLinkAttribute($value)
    {
        return config('constants.DOWNLOAD_SERVER_PROTOCOL').config('constants.CDN_SERVER_NAME').'/'.$value;
    }

    public function user()
    {
        return $this->belongsTo(User::Class);
    }
}
