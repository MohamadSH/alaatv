<?php

namespace App;

/**
 * App\Section
 *
 * @property string|null $name        نام
 * @property int         $order       ترتیب
 * @property int         $id
 * @property boolean     enable       فعال/غیرفعال
 */
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
