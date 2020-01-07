<?php

namespace App;

use Illuminate\Support\Facades\Storage;

/**
 * @property string title
 * @property string link
 * @property string photo
 */
class Source extends BaseModel
{
    protected $fillable = [
        'title',
        'link',
        'photo',
    ];

    /*
    |--------------------------------------------------------------------------
    | mutators
    |--------------------------------------------------------------------------
    */

    public function getPhotoAttribute($value)
    {
        if (is_null($value))
            return $value;

        $diskAdapter = Storage::disk('alaaCdnSFTP')->getAdapter();
        $imageUrl    = $diskAdapter->getUrl($value);
        return isset($imageUrl) ? $imageUrl : null;
    }

    /*
    |--------------------------------------------------------------------------
    | relations
    |--------------------------------------------------------------------------
    */

    public function sets()
    {
        return $this->morphedByMany(Contentset::class, 'sourceable')
            ->withTimestamps()
            ->withPivot(['order'])
            ->orderBy('sourceable.order');
    }

    public function contents()
    {
        return $this->morphedByMany(Content::class, 'sourceable')
            ->withTimestamps()
            ->withPivot(['order'])
            ->orderBy('sourceable.order');
    }
}
