<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\LiveDescription;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class LiveDescriptionController extends Controller
{
    public function __construct()
    {
        $this->callMiddlewares($this->getAuthExceptionArray());
    }

    /**
     * @param $authException
     */
    private function callMiddlewares(array $authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:' . config('constants.LIST_LIVE_DESCRIPTION_ACCESS'), ['only' => ['index',],]);
        $this->middleware('permission:' . config('constants.INSERT_LIVE_DESCRIPTION_ACCESS'), ['only' => ['store', 'create'],]);
        $this->middleware('permission:' . config('constants.UPDATE_LIVE_DESCRIPTION_ACCESS'), ['only' => ['update',],]);
        $this->middleware('permission:' . config('constants.SHOW_LIVE_DESCRIPTION_ACCESS'), ['only' => ['show', 'edit'],]);
        $this->middleware('permission:' . config('constants.DELETE_LIVE_DESCRIPTION_ACCESS'), ['only' => ['destroy',],]);
    }

    /**
     * @return array
     */
    private function getAuthExceptionArray(): array
    {
        return [];
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $liveDescriptions = LiveDescription::query();
        $product          = $request->get('product_id');
        if (isset($product)) {
            $liveDescriptions->where('product_id', $product);
        }

        return $liveDescriptions->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Tehran');
        $liveDescription = LiveDescription::create($request->all());
        date_default_timezone_set('UTC');

        if (isset($liveDescription)) {
            session()->flash('success', 'توضیح لحظه ای با موفقیت درج شد');
        } else {
            session()->flash('error', 'خطا در درج توصیح لحظه ای');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param LiveDescription $liveDescription
     *
     * @return JsonResponse
     */
    public function show(LiveDescription $liveDescription)
    {
        return response()->json([
            $liveDescription,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LiveDescription $liveDescription
     *
     * @return Factory|View
     */
    public function edit(LiveDescription $liveDescription)
    {
        return view('liveDescription.edit', compact('liveDescription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request         $request
     * @param LiveDescription $liveDescription
     *
     * @return RedirectResponse
     */
    public function update(Request $request, LiveDescription $liveDescription)
    {
        if ($liveDescription->update($request->all())) {
            Cache::tags('livedescription_' . $liveDescription->id)->flush();
            session()->flash('success', 'توضیح لحظه ای با موفقیت اصلاح شد');
        } else {
            session()->flash('error', 'خطا در اصلاح توصیح لحظه ای');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LiveDescription $liveDescription
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(LiveDescription $liveDescription)
    {
        if ($liveDescription->delete()) {
            return response()->json([
                'message' => 'توضیح لخظه ای با موفقیت حذف شد',
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Error on removing Description',
            ],
        ]);
    }
}
