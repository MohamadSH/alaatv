<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

/**
 * App\File
 *
 * @property int                       $id
 * @property string|null               $uuid شناسه منحصر به فرد سراسری
 * @property string                    $name نام فایل
 * @property Carbon|null       $created_at
 * @property Carbon|null       $updated_at
 * @property Carbon|null       $deleted_at
 * @property-read Collection|Disk[]    $disks
 * @property-read Collection|Content[] $contents
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|File onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|File whereCreatedAt($value)
 * @method static Builder|File whereDeletedAt($value)
 * @method static Builder|File whereId($value)
 * @method static Builder|File whereName($value)
 * @method static Builder|File whereUpdatedAt($value)
 * @method static Builder|File whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|File withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|File newModelQuery()
 * @method static Builder|File newQuery()
 * @method static Builder|File query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                   $cache_cooldown_seconds
 * @property-read int|null                                                $contents_count
 * @property-read int|null                                                $disks_count
 */
class File extends BaseModel
{
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
        return $this->belongsToMany('App\Content', 'educationalcontent_file', 'file_id', 'content_id')
            ->withPivot("caption");
    }

    public function disks()
    {
        return $this->belongsToMany("\App\Disk")
            ->orderBy("priority")
            ->withPivot("priority");
    }

    public function getUrl()
    {
        $fileRemotePath = "";
        $disk           = $this->disks->first();
        if (isset($disk)) {
            $diskAdapter = Storage::disk($disk->name)
                ->getAdapter();
            $diskType    = class_basename($diskAdapter);
            $sftpRoot    = config("constants.SFTP_ROOT");
            $dProtocol   = config("constants.DOWNLOAD_SERVER_PROTOCOL");
            $dName       = config("constants.PAID_SERVER_NAME");

            switch ($diskType) {
                case "SftpAdapter" :
                    //                $fileHost = $diskAdapter->getHost();
                    $fileRoot       = $diskAdapter->getRoot();
                    $fileRemotePath = str_replace($sftpRoot, $dProtocol . $dName, $fileRoot);
                    $fileRemotePath .= $this->name;
                    break;
            }

            return $fileRemotePath;
        } else {
            return action("Web\ErrorPageController@error404");
        }
    }

    public function getExtention()
    {
        $ext = pathinfo($this->name, PATHINFO_EXTENSION);

        return $ext;
    }
}
