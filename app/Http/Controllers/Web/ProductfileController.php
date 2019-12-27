<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditProductfileRequest;
use App\Http\Requests\InsertProductfileRequest;
use App\Product;
use App\Productfile;
use App\Productfiletype;
use App\Traits\ProductCommon;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductfileController extends Controller
{
    use ProductCommon;

    protected $response;

    function __construct()
    {
        $this->middleware('permission:' . config('constants.LIST_PRODUCT_FILE_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_PRODUCT_FILE_ACCESS'), [
            'only' => [
                'create',
                'store',
            ],
        ]);
        $this->middleware('permission:' . config('constants.REMOVE_PRODUCT_FILE_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.EDIT_PRODUCT_FILE_ACCESS'), [
            'only' => [
                'edit',
                'update',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function create(Request $request)
    {
        $productId                = $request->get("product");
        $product                  = Product::FindOrFail($productId);
        $productFileTypes         = Productfiletype::pluck('displayName', 'id')
            ->toArray();
        $defaultProductFileOrders = collect();
        foreach ($productFileTypes as $key => $productFileType) {
            $lastProductFile = $product->productfiles->where("productfiletype_id", $key)
                ->sortByDesc("order")
                ->first();
            if (isset($lastProductFile)) {
                $lastOrderNumber = $lastProductFile->order + 1;
                $defaultProductFileOrders->push([
                    "fileTypeId" => $key,
                    "lastOrder"  => $lastOrderNumber,
                ]);
            } else {
                $defaultProductFileOrders->push([
                    "fileTypeId" => $key,
                    "lastOrder"  => 1,
                ]);
            }
        }
        $productFileTypes = Arr::add($productFileTypes, 0, "انتخاب کنید");
        $productFileTypes = Arr::sortRecursive($productFileTypes);

        $products = $this->makeProductCollection();

        return view("product.productFile.create",
            compact("product", "products", "productFileTypes", "defaultProductFileOrders"));
    }

    public function store(InsertProductfileRequest $request)
    {
        $productFile = new Productfile();
        $productFile->fill($request->all());
        $time = $request->get("time");
        if (strlen($time) > 0) {
            $time = Carbon::parse($time)
                ->format('H:i:s');
        } else {
            $time = "00:00:00";
        }
        $validSince              = $request->get("validSinceDate");
        $validSince              = Carbon::parse($validSince)
            ->format('Y-m-d');
        $validSince              = $validSince . " " . $time;
        $productFile->validSince = $validSince;

        if ($request->get("enable") != 1) {
            $productFile->enable = 0;
        }

        if ($request->hasFile("file")) {
            $file      = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName  =
                basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(config('constants.DISK13'))
                ->put($fileName, File::get($file))) {
                $productFile->file = $fileName;
            }
        }

        if ($request->has("cloudFile")) {
            $link                   = $request->get("cloudFile");
            $productFile->cloudFile = $link;
            if (!$request->hasFile("file")) {
                $fileName          = basename($link);
                $productFile->file = $fileName;
            }
        }

        if ($productFile->productfiletype_id == 0) {
            $productFile->productfiletype_id = null;
        }

        if ($request->has("order") && isset($productFile->product->id)) {
            if (strlen(preg_replace('/\s+/', '', $request->get("order"))) == 0) {
                $productFile->order = 0;
            }
            $filesWithSameOrder = Productfile::all()
                ->where("product_id", $productFile->product->id)
                ->where("productfiletype_id",
                    $productFile->productfiletype->id)
                ->where("order", $productFile->order);
            if (!$filesWithSameOrder->isEmpty()) {
                $filesWithGreaterOrder = Productfile::all()
                    ->where("productfiletype_id", $productFile->productfiletype->id)
                    ->where("order", ">=",
                        $productFile->order);
                foreach ($filesWithGreaterOrder as $graterProductFile) {
                    $graterProductFile->order = $graterProductFile->order + 1;
                    $graterProductFile->update();
                }
            }
        }

        if ($productFile->save()) {
            session()->put('success', 'درج فایل با موفقیت انجام شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }

    public function edit($productFile)
    {
        $validDate        = Carbon::parse($productFile->validSince)
            ->format('Y-m-d');
        $validTime        = Carbon::parse($productFile->validSince)
            ->format('H:i');
        $productFileTypes = Productfiletype::pluck('displayName', 'id')
            ->toArray();
        $productFileTypes = Arr::add($productFileTypes, 0, "انتخاب کنید");
        $productFileTypes = Arr::sortRecursive($productFileTypes);

        return view("product.productFile.edit", compact("productFile", "validDate", "validTime", "productFileTypes"));
    }

    public function update(EditProductfileRequest $request, $productFile)
    {
        $oldFile = $productFile->file;
        $productFile->fill($request->all());

        $time = $request->get("time");
        if (strlen($time) > 0) {
            $time = Carbon::parse($time)
                ->format('H:i:s');
        } else {
            $time = "00:00:00";
        }
        $validSince = $request->get("validSinceDate");
        //        $validSince = Carbon::parse($validSince)->format('Y-m-d');
        $validSince              = Carbon::parse($validSince)
            ->addDay()
            ->format('Y-m-d'); //Muhammad : added a day because it returns one day behind and IDK why!!
        $validSince              = $validSince . " " . $time;
        $productFile->validSince = $validSince;

        if ($request->get("enable") != 1) {
            $productFile->enable = 0;
        }

        if ($request->hasFile("file")) {
            $file      = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName  =
                basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(config('constants.DISK13'))
                ->put($fileName, File::get($file))) {
                Storage::disk(config('constants.DISK13'))
                    ->delete($oldFile);
                $productFile->file = $fileName;
            }
        }

        if ($request->has("cloudFile")) {
            $link                   = $request->get("cloudFile");
            $productFile->cloudFile = $link;
            if (!$request->hasFile("file")) {
                $fileName          = basename($link);
                $productFile->file = $fileName;
            }
        }

        if ($productFile->productfiletype_id == 0) {
            $productFile->productfiletype_id = null;
        }

        if ($request->has("order") && isset($productFile->product->id)) {
            if (strlen(preg_replace('/\s+/', '', $request->get("order"))) == 0) {
                $productFile->order = 0;
            }
            $filesWithSameOrder = Productfile::all()
                ->where("id", "<>", $productFile->id)
                ->where("product_id",
                    $productFile->product->id)
                ->where("productfiletype_id", $productFile->productfiletype->id)
                ->where("order", $productFile->order);
            if (!$filesWithSameOrder->isEmpty()) {
                $filesWithGreaterOrder = Productfile::all()
                    ->where("productfiletype_id", $productFile->productfiletype->id)
                    ->where("order", ">=",
                        $productFile->order);
                foreach ($filesWithGreaterOrder as $graterProductFile) {
                    $graterProductFile->order = $graterProductFile->order + 1;
                    $graterProductFile->update();
                }
            }
        }

        if ($productFile->update()) {
            session()->put('success', 'اصلاح جزوه با موفقیت انجام شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }
}
