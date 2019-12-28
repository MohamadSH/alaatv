<?php

namespace App\Http\Controllers\Web;

use App\Descriptionwithperiod;
use App\Http\Controllers\Controller;
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

class PeriodDescriptionController extends Controller
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
        $this->middleware('permission:' . config('constants.LIST_PERIOD_DESCRIPTION_ACCESS'), ['only' => ['index',],]);
        $this->middleware('permission:' . config('constants.INSERT_PERIOD_DESCRIPTION_ACCESS'), ['only' => ['store', 'create'],]);
        $this->middleware('permission:' . config('constants.UPDATE_PERIOD_DESCRIPTION_ACCESS'), ['only' => ['update',],]);
        $this->middleware('permission:' . config('constants.SHOW_PERIOD_DESCRIPTION_ACCESS'), ['only' => ['show', 'edit'],]);
        $this->middleware('permission:' . config('constants.DELETE_PERIOD_DESCRIPTION_ACCESS'), ['only' => ['destroy',],]);
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
        $periodDescriptions = Descriptionwithperiod::query();
        $product            = $request->get('product_id');
        if (isset($product)) {
            $periodDescriptions->where('product_id', $product);
        }

        return $periodDescriptions->get();
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
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Tehran');
        $request->offsetSet('staff_id', $request->user()->id);
        $description = Descriptionwithperiod::create($request->all());
        date_default_timezone_set('UTC');

        if (isset($description)) {
            session()->flash('success', 'توضیح بازه ای با موفقیت درج شد');
        } else {
            session()->flash('error', 'خطا در درج توصیح بازه ای');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Descriptionwithperiod $descriptionwithperiod
     *
     * @return JsonResponse
     */
    public function show(Descriptionwithperiod $descriptionwithperiod)
    {
        return response()->json([
            $descriptionwithperiod,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Descriptionwithperiod $periodDescription
     *
     * @return Factory|View
     */
    public function edit(Descriptionwithperiod $periodDescription)
    {
        return view('product.periodDescription.edit', compact('periodDescription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request               $request
     * @param Descriptionwithperiod $descriptionwithperiod
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Descriptionwithperiod $descriptionwithperiod)
    {
        if ($descriptionwithperiod->update($request->all())) {
            Cache::tags('periodDescription_' . $descriptionwithperiod->id)->flush();
            session()->flash('success', 'توضیح لحظه ای با موفقیت اصلاح شد');
        } else {
            session()->flash('error', 'خطا در اصلاح توصیح لحظه ای');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Descriptionwithperiod $descriptionwithperiod
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Descriptionwithperiod $descriptionwithperiod)
    {
        if ($descriptionwithperiod->delete()) {
            return response()->json([
                'message' => 'Description has been removed successfully',
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Error on removing Description',
            ],
        ]);
    }
}
