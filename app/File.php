<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

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

    public function educationalcontents()
    {
        return $this->belongsToMany('App\Educationalcontent', 'educationalcontent_file', 'file_id', 'content_id')->withPivot("caption");
    }

    public function disks()
    {
        return $this->belongsToMany("\App\Disk")->orderBy("priority")->withPivot("priority");
    }

    public function getUrl()
    {
        $fileRemotePath = "";
        $diskAdapter = Storage::disk($this->disks->first()->name)->getAdapter();
        $diskType = class_basename($diskAdapter);
        switch ($diskType) {
            case "SftpAdapter" :
                $fileHost = $diskAdapter->getHost();
                if (isset($fileHost)) {
                    $fileRoot = $diskAdapter->getRoot();
                    $fileRemotePath = env("DOWNLOAD_SERVER_PROTOCOL") . $fileHost . ":" . env("DOWNLOAD_SERVER_PORT") . "/" . env("DOWNLOAD_SERVER_PARTIAL_PATH") . explode("public", $fileRoot)[1];
                    $fileRemotePath .= $this->name;
                }
                break;
        }
        return $fileRemotePath;
    }

    public function getExtention()
    {
        $ext = pathinfo($this->name, PATHINFO_EXTENSION);
        return $ext;
    }
}
