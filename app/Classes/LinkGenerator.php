<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-08-23
 * Time: 15:22
 */

namespace App\Classes;


use App\Adapter\AlaaSftpAdapter;
use App\File;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Adapter\Local;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Sftp\SftpAdapter;

/**
 * Class LinkGenerator
 * @package App\Classes
 */
class LinkGenerator
{
    protected $uuid;
    protected $disk;
    protected $url;
    protected $fileName;

    protected const DOWNLOAD_CONTROLLER_NAME = "HomeController@newDownload";

    /**
     * LinkGenerator constructor.
     * @param $file
     */
    public function __construct(\stdClass $file)
    {
        $this->setDisk($file->disk)
            ->setUuid($file->uuid)
            ->setUrl($file->url)
            ->setFileName($file->fileName);
    }

    /**
     * LinkGenerator constructor.
     * @param $uuid
     * @param $disk
     * @param $url
     * @param $fileName
     * @return LinkGenerator
     */
    public static function create($uuid, $disk, $url, $fileName)
    {
        $input = new \stdClass();
//        dd("0");
        $input->disk = null;
//        dd("1");
        if (isset($disk))
            $input->disk = $disk;
        else if (isset($uuid)) {
            $input->disk = self::findDiskNameFromUUID($uuid);
        }
//        dd("2");
        $input->uuid = $uuid;
        $input->url = $url;
        $input->fileName = $fileName;
//        dd($input);
        return new LinkGenerator($input);
    }

    /**
     * @param mixed $fileName
     * @return LinkGenerator
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @param mixed $url
     * @return LinkGenerator
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param mixed $uuid
     * @return LinkGenerator
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @param mixed $disk
     * @return LinkGenerator
     */
    public function setDisk($disk)
    {
        $this->disk = $disk;
        return $this;
    }

    /**
     * @param $uuid
     * @return null | string
     */
    private static function findDiskNameFromUUID($uuid)
    {
        $file = File::where("uuid", $uuid)->get();
        if ($file->isNotEmpty() && $file->count() == 1) {
            $file = $file->first();
            if ($file->disks->isNotEmpty()) {
                return $file->disks->first()->name;
            }
        }
        return null;
    }

    /**
     * @param array|null $paid
     * @return array|null|string
     * @throws \Exception
     */
    public function getLinks(array $paid = null)
    {
        if (isset($this->url))
            return $this->url;
        if (isset($this->disk) && isset($this->fileName)) {

            $diskAdapter = Storage::disk($this->disk)->getAdapter();
            $url = $this->fetchUrl($diskAdapter,$this->fileName);
            if(isset($paid)){
                $data = encrypt([
                    $url,
                    $paid['content_id']
                ]);
                return action(self::DOWNLOAD_CONTROLLER_NAME,$data);

            }else{
                return $url;
            }
        } else {
            throw new \Exception("DiskName and FileName should be set \n File uuid=" . $this->uuid);
        }
    }
    private function fetchUrl(AlaaSftpAdapter $diskAdapter , $fileName){
        return $diskAdapter->getUrl($fileName);
    }
    /**
     * @return array
     */
    private function stream()
    {
        $f = $this;
        $fs = Storage::disk($f->disk)->getDriver();
        try {
            $stream = $fs->readStream($f->fileName);
            $result = [
                "read-stream" => $stream,
            ];
        } catch (FileNotFoundException $e) {
            $result = [
                "read-stream" => null,
                "exception" => $e
            ];
        }

        return $result;
    }

}