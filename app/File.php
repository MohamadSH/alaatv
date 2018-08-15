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
        $disk = $this->disks->first();
        if(isset($disk))
        {
            $diskAdapter = Storage::disk($disk->name)->getAdapter();
            $diskType = class_basename($diskAdapter);
            $sftpRoot = config("constants.SFTP_ROOT");
            $dProtocol = config("constants.DOWNLOAD_HOST_PROTOCOL");
            $dName = config("constants.DOWNLOAD_HOST_NAME");

            switch ($diskType) {
                case "SftpAdapter" :
//                $fileHost = $diskAdapter->getHost();
                    $fileRoot = $diskAdapter->getRoot();
                    $fileRemotePath = str_replace($sftpRoot , $dProtocol.$dName ,$fileRoot );
                    $fileRemotePath .= $this->name;
                    break;
            }
            return $fileRemotePath;
        }
        else
        {
            return action("HomeController@error404");
        }

    }

    public function getExtention()
    {
        $ext = pathinfo($this->name, PATHINFO_EXTENSION);
        return $ext;
    }
}
