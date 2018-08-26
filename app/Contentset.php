<?php

namespace App;

use App\Classes\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Contentset
 *
 * @property int $id
 * @property string|null $name نام
 * @property string|null $description توضیح
 * @property string|null $photo عکس پوستر
 * @property string|null $tags تگ ها
 * @property int $enable فعال/غیرفعال
 * @property int $display نمایش/عدم نمایش
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Content[] $contents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Contentset onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contentset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Contentset withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Contentset withoutTrashed()
 * @mixin \Eloquent
 */
class Contentset extends Model implements Taggable
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'tags',
        'photo'
    ];


    public function contents()
    {
        return $this->belongsToMany(
            "\App\Content",
            "contentset_educationalcontent",
            "contentset_id",
            "edc_id")
            ->withPivot("order", "isDefault");
    }

    public function getTagsAttribute($value)
    {
        return json_decode($value);
    }

//    public function setTagsAttribute($value)
//    {
//        return json_encode($value);
//    }
    public function retrievingTags()
    {
        /**
         *      Retrieving Tags
         */
        $response = $this->sendRequest(
            config("constants.TAG_API_URL") . "id/contentset/" . $this->id,
            "GET"
        );

        if ($response["statusCode"] == 200) {
            $result = json_decode($response["result"]);
            $tags = $result->data->tags;
        } else {
            $tags = [];
        }

        return $tags;
    }
}
