<?php

namespace App;

class Section extends BaseModel
{
    protected $fillable = [
        'name',
        'order',
        'enable',
    ];

    public function contents()
    {
        return $this->hasMany(Content::Class);
    }
}
