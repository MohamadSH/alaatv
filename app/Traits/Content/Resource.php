<?php


namespace App\Traits\Content;


use App\Content;
use App\Http\Resources\PamphletFile;
use App\Http\Resources\VideoFile;

trait Resource
{

    public function getContentFile()
    {
        if ($this->resource instanceof Content) {
            $file                   = $this->file;
            $videoFileCollection    = $file->get('video') ?? collect();
            $pamphletFileCollection = $file->get('pamphlet') ?? collect();
            return [
                'video'    => $this->when(isset($videoFileCollection), function () use ($videoFileCollection) {
                    return $videoFileCollection->count() > 0 ? VideoFile::collection($videoFileCollection) : null;
                }),
                'pamphlet' => $this->when(isset($pamphletFileCollection), function () use ($pamphletFileCollection) {
                    return $pamphletFileCollection->count() > 0 ? PamphletFile::collection($pamphletFileCollection) : null;
                }),
            ];
        }
        return [

        ];
    }

    public function hasFile(): bool
    {
        if ($this->resource instanceof Content) {
            return $this->contenttype_id == config('constants.CONTENT_TYPE_PAMPHLET') || $this->contenttype_id == config('constants.CONTENT_TYPE_VIDEO');
        }
        return false;
    }
}
