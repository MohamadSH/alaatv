<?php

namespace App;

/**
 * @property mixed id
 */
class LiveDescription extends BaseModel
{

    protected $table = 'livedescriptions';

    protected $fillable = [
        'product_id',
        'title',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
