<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Productphoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductphotoController extends Controller
{
    protected $response;
    
    function __construct()
    {
        $this->response = new Response();
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
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;
            if (Storage::disk(Config::get('constants.DISK4'))
                ->put($fileName, File::get($file))) {
                $photo->file = $fileName;
            }
        }
        
        if ($request->has("order") && isset($photo->product->id)) {
            if (strlen(preg_replace('/\s+/', '', $request->get("order"))) == 0) {
                $photo->order = 0;
            }
            $filesWithSameOrder = Productphoto::all()
                ->where("product_id", $photo->product->id)
                ->where("order", $photo->order);
            if (!$filesWithSameOrder->isEmpty()) {
                $filesWithGreaterOrder = Productphoto::all()
                    ->where("order", ">=", $photo->order);
                foreach ($filesWithGreaterOrder as $graterProductPhoto) {
                    $graterProductPhoto->order = $graterProductPhoto->order + 1;
                    $graterProductPhoto->update();
                }
            }
        }
        
        if ($photo->save()) {
            session()->put('success', 'درج عکس با موفقیت انجام شد');
        }
        else {
            session()->put('error', 'خطای پایگاه داده');
        }
        
        return redirect()->back();
    }

    public function destroy(Productphoto $productphoto)
    {
        if ($productphoto->delete()) {
            
            return $this->response->setStatusCode(200);
        }
        else {
            return $this->response->setStatusCode(503);
        }
    }
}
