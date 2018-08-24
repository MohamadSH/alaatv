<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-08-23
 * Time: 15:22
 */

namespace App\Classes;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Adapter\Local;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Sftp\SftpAdapter;

class LinkGenerator
{
    protected $uuid;
    protected $disk;
    protected $url;
    protected $type;
    protected $fileName;

    /**
     * PHP 5 allows developers to declare constructor methods for classes.
     * Classes which have a constructor method call this method on each newly-created object,
     * so it is suitable for any initialization that the object may need before it is used.
     *
     * Note: Parent constructors are not called implicitly if the child class defines a constructor.
     * In order to run a parent constructor, a call to parent::__construct() within the child constructor is required.
     *
     * param [ mixed $args [, $... ]]
     * @param Collection $file
     * @link http://php.net/manual/en/language.oop5.decon.php
     */
    public function __construct($file)
    {
        $this->setDisk($file->disk)
            ->setUuid($file->uuid)
            ->setType($file->type)
            ->setUrl($file->url)
            ->setFileName($file->fileName);
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
     * @param mixed $type
     * @return LinkGenerator
     */
    public function setType($type)
    {
        $this->type = $type;
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
     *
     * @throws \Exception
     */
    public function getLinks()
    {
        if (isset($this->url))
            return $this->url;
        if (isset($this->disk) && isset($this->fileName)) {
            if (Storage::disk($this->disk)->exists($this->fileName)) {
                $diskAdapter = Storage::disk($this->disk)->getAdapter();
                if ($diskAdapter instanceof SftpAdapter) {
                    return $this->makeSftpUrl($diskAdapter);
                } else if ($diskAdapter instanceof Local) {
                    dd("Hello4");
                    //TODO:// remove after file transfer to SFTP Disk
                    return $this->stream();
                }
            }
            return null;
        } else {
            throw new \Exception("DiskName and FileName should be set \n File uuid=" . $this->uuid);
        }
    }

    private function makeSftpUrl(SftpAdapter $diskAdapter): string
    {
        $sftpRoot = config("constants.SFTP_ROOT");
        $dProtocol = config("constants.DOWNLOAD_HOST_PROTOCOL");
        $dName = config("constants.DOWNLOAD_HOST_NAME");

        $fileRoot = $diskAdapter->getRoot();

        return str_replace($sftpRoot, $dProtocol . $dName, $fileRoot) . $this->fileName;
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