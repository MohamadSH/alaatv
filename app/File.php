<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

/**
 * App\File
 *
 * @property int $id
 * @property string|null $uuid شناسه منحصر به فرد سراسری
 * @property string $name نام فایل
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Disk[] $disks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Content[] $contents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\File onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\File withoutTrashed()
 * @mixin \Eloquent
 */
class File extends Model
{
    use SoftDeletes;

    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'uuid',
    ];

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string)Uuid::generate(4);
        });
    }

    public function contents()
    {
        return $this->belongsToMany('App\Content', 'educationalcontent_file', 'file_id', 'content_id')->withPivot("caption");
    }

    public function disks()
    {
        return $this->belongsToMany("\App\Disk")->orderBy("priority")->withPivot("priority");
    }

    public function getUrl()
    {
        $fileRemotePath = "";
        $disk = $this->disks->first();
        if (isset($disk)) {
            $diskAdapter = Storage::disk($disk->name)->getAdapter();
            $diskType = class_basename($diskAdapter);
            $sftpRoot = config("constants.SFTP_ROOT");
            $dProtocol = config("constants.DOWNLOAD_HOST_PROTOCOL");
            $dName = config("constants.DOWNLOAD_HOST_NAME");

            switch ($diskType) {
                case "SftpAdapter" :
//                $fileHost = $diskAdapter->getHost();
                    $fileRoot = $diskAdapter->getRoot();
                    $fileRemotePath = str_replace($sftpRoot, $dProtocol . $dName, $fileRoot);
                    $fileRemotePath .= $this->name;
                    break;
            }
            return $fileRemotePath;
        } else {
            return action("HomeController@error404");
        }

    }

    public function getExtention()
    {
        $ext = pathinfo($this->name, PATHINFO_EXTENSION);
        return $ext;
    }
}
