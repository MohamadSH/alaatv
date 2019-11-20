<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use Illuminate\Support\Facades\{File, Storage};



class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except'=>[ 'satra' , 'bigUpload' ]]);
    }

    public function debug(Request $request)
    {
        return response()->json([
            'user'  => $request->user(),
            'debug' => 2,
        ]);
    }

    public function authTest(Request $request)
    {
        return response()->json([
            'User' => $request->user(),
        ]);
    }

    public function bigUpload(Request $request)
    {
        $filePath         = $request->header('X-File-Name');
        $originalFileName = $request->header('X-Dataname');
        $filePrefix       = '';
        $contentSetId     = $request->header('X-Dataid');
        $disk             = $request->header('X-Datatype');
        $done             = false;

        try {
            $dirname  = pathinfo($filePath, PATHINFO_DIRNAME);
            $ext      = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $fileName = basename($originalFileName, '.'.$ext).'_'.date('YmdHis').'.'.$ext;

            $newFileNameDir = $dirname.'/'.$fileName;

            if (File::exists($newFileNameDir)) {
                File::delete($newFileNameDir);
            }
            File::move($filePath, $newFileNameDir);

            if (strcmp($disk, 'product') == 0) {
                if ($ext == 'mp4') {
                    $directory = 'video';
                } else {
                    if ($ext == 'pdf') {
                        $directory = 'pamphlet';
                    }
                }

                $adapter    = new SftpAdapter([
                    'host'          => config('constants.SFTP_HOST'),
                    'port'          => config('constants.SFTP_PORT'),
                    'username'      => config('constants.SFTP_USERNAME'),
                    'password'      => config('constants.SFTP_PASSSWORD'),
                    'privateKey'    => config('constants.SFTP_PRIVATE_KEY_PATH'),
                    'root'          => config('constants.SFTP_ROOT').'/private/'.$contentSetId.'/',
                    'timeout'       => config('constants.SFTP_TIMEOUT'),
                    'directoryPerm' => 0755,
                ]);
                $filesystem = new Filesystem($adapter);
                if (isset($directory)) {
                    if (!$filesystem->has($directory)) {
                        $filesystem->createDir($directory);
                    }

                    $filePrefix = $directory.'/';
                    $filesystem = $filesystem->get($directory);
                    $path       = $filesystem->getPath();
                    $filesystem->setPath($path.'/'.$fileName);
                    if ($filesystem->put(fopen($newFileNameDir, 'r+'))) {
                        $done = true;
                    }
                } else {
                    if ($filesystem->put($fileName, fopen($newFileNameDir, 'r+'))) {
                        $done = true;
                    }
                }
            }
            elseif (strcmp($disk, 'video') == 0) {
                $adapter    = new SftpAdapter([
                    'host'          => config('constants.SFTP_HOST'),
                    'port'          => config('constants.SFTP_PORT'),
                    'username'      => config('constants.SFTP_USERNAME'),
                    'password'      => config('constants.SFTP_PASSSWORD'),
                    'privateKey'    => config('constants.SFTP_PRIVATE_KEY_PATH'),
                    // example:  /alaa_media/cdn/media/203/HD_720p , /alaa_media/cdn/media/thumbnails/203/
                    'root'          => config('constants.DOWNLOAD_SERVER_ROOT').config('constants.DOWNLOAD_SERVER_MEDIA_PARTIAL_PATH').$contentSetId,
                    'timeout'       => config('constants.SFTP_TIMEOUT'),
                    'directoryPerm' => 0755,
                ]);
                $filesystem = new Filesystem($adapter);
                if ($filesystem->put($originalFileName, fopen($newFileNameDir, 'r+'))) {
                    $done = true;
                    // example:  https://cdn.sanatisharif.ir/media/203/hq/203001dtgr.mp4
                    $fileName = config('constants.DOWNLOAD_SERVER_PROTOCOL').config('constants.CDN_SERVER_NAME').config('constants.DOWNLOAD_SERVER_MEDIA_PARTIAL_PATH').$contentSetId.$originalFileName;
                }
            }
            else {
                $filesystem = Storage::disk($disk);
                //                Storage::putFileAs('photos', new File('/path/to/photo'), 'photo.jpg');
                if ($filesystem->put($fileName, fopen($newFileNameDir, 'r+'))) {
                    $done = true;
                }
            }

            if ($done) {
                return response()->json([
                    'fileName' => $fileName,
                    'prefix'   => $filePrefix,
                ]);
            } else {
                return response()->json([] , Response::HTTP_SERVICE_UNAVAILABLE);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'unexpected error',
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ] , Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function satra()
    {
        $contents =  Cache::tags(['satra'])->remember('satra_api', config('constants.CACHE_60'), function (){
            return \App\Content::query()
                ->orderByDesc('created_at')
                ->where('contenttype_id' , config('constants.CONTENT_TYPE_VIDEO'))
                ->active()
                ->limit(5)
                ->get();
        });

        $contentArray = [];
        foreach ($contents as $content) {
            $validSince = $content->ValidSince_Jalali(false);
            $createdAt  = $content->CreatedAt_Jalali();
            $contentArray[] = [
                'id'            => $content->id,
                'url'           => $content->url,
                'title'         => $content->name,
                'published_at'  => isset($validSince)?$validSince:$createdAt,
                'visit_count'  => 0
            ];
        }

        return response()->json($contentArray);
    }
}
