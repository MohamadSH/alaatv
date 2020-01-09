<?php

namespace App\Http\Controllers\Web;

use App\Adapter\AlaaSftpAdapter;
use App\Http\Controllers\Controller;
use App\Productphoto;
use App\Traits\FileCommon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductphotoController extends Controller
{
    use FileCommon;

    function __construct()
    {

    }

    public function store(Request $request)
    {
        $photo = new Productphoto();
        $photo->fill($request->all());
        if ($request->get("enable") != 1) {
            $photo->enable = 0;
        }

        if ($request->hasFile("file")) {
            $file      = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName  =
                basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            $disk      = Storage::disk(config('constants.DISK21'));
            /** @var AlaaSftpAdapter $adaptor */
            $adaptor = $disk->getAdapter();
            if ($disk->put($fileName, File::get($file))) {
                $fullPath    = $adaptor->getRoot();
                $partialPath = $this->getSubDirectoryInCDN($fullPath);
                $photo->file = $partialPath . $fileName;
            }
        }

//        if ($request->has("order") && isset($photo->product->id)) {
//            if (strlen(preg_replace('/\s+/', '', $request->get("order"))) == 0) {
//                $photo->order = 0;
//            }
//            $filesWithSameOrder = Productphoto::all()
//                ->where("product_id", $photo->product->id)
//                ->where("order", $photo->order);
//            if (!$filesWithSameOrder->isEmpty()) {
//                $filesWithGreaterOrder = Productphoto::all()
//                    ->where("order", ">=", $photo->order);
//                foreach ($filesWithGreaterOrder as $graterProductPhoto) {
//                    $graterProductPhoto->order = $graterProductPhoto->order + 1;
//                    $graterProductPhoto->update();
//                }
//            }
//        }

        if ($photo->save()) {
            session()->put('success', 'درج عکس با موفقیت انجام شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }


    public function destroy(Productphoto $productphoto)
    {
        if ($productphoto->delete()) {
            return response()->json([]);
        } else {
            return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
