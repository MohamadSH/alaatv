<?php

namespace App;

use App\Traits\DateTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveDescription extends Model
{
    use SoftDeletes , DateTrait;

    protected $table = 'livedescriptions';

    protected $fillable=[
        'product_id',
        'title',
        'description',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
