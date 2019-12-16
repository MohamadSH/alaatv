<?php

namespace App\Http\Controllers\Web;

use App\Descriptionwithperiod;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PeriodDescriptionController extends Controller
{
    public function __construct()
    {
        $this->callMiddlewares($this->getAuthExceptionArray());
    }

    /**
     * @return array
     */
    private function getAuthExceptionArray(): array
    {
        return [];
    }

    /**
     * @param $authException
     */
    private function callMiddlewares(array $authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:'.config('constants.LIST_PERIOD_DESCRIPTION_ACCESS'),    ['only' => ['index',],]);
        $this->middleware('permission:'.config('constants.INSERT_PERIOD_DESCRIPTION_ACCESS'),  ['only' => ['store', 'create'],]);
        $this->middleware('permission:'.config('constants.UPDATE_PERIOD_DESCRIPTION_ACCESS'),  ['only' => ['update',],]);
        $this->middleware('permission:'.config('constants.SHOW_PERIOD_DESCRIPTION_ACCESS'),    ['only' => ['show','edit'],]);
        $this->middleware('permission:'.config('constants.DELETE_PERIOD_DESCRIPTION_ACCESS'),  ['only' => ['destroy',],]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $periodDescriptions = Descriptionwithperiod::query();
        $product = $request->get('product_id');
        if(isset($product)){
            $periodDescriptions->where('product_id' , $product);
        }

        return $periodDescriptions->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Tehran');
        $request->offsetSet('staff_id', $request->user()->id);
        $description = Descriptionwithperiod::create($request->all());
        date_default_timezone_set('UTC');

        if(isset($description)){
            session()->flash('success' , 'توضیح بازه ای با موفقیت درج شد');
        }else{
            session()->flash('error' , 'خطا در درج توصیح بازه ای');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Descriptionwithperiod $descriptionwithperiod
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Descriptionwithperiod $descriptionwithperiod)
    {
        return response()->json([
            $descriptionwithperiod
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Descriptionwithperiod $periodDescription
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Descriptionwithperiod $periodDescription)
    {
        return view('product.periodDescription.edit' , compact('periodDescription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Descriptionwithperiod $descriptionwithperiod
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Descriptionwithperiod $descriptionwithperiod)
    {
        if($descriptionwithperiod->update($request->all())){
            Cache::tags('periodDescription_'.$descriptionwithperiod->id)->flush();
            session()->flash('success' , 'توضیح لحظه ای با موفقیت اصلاح شد');
        }else{
            session()->flash('error' , 'خطا در اصلاح توصیح لحظه ای');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Descriptionwithperiod $descriptionwithperiod
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Descriptionwithperiod $descriptionwithperiod)
    {
        if($descriptionwithperiod->delete()){
           return response()->json([
               'message'    => 'Description has been removed successfully',
           ]);
        }

        return response()->json([
            'error' => [
                'message'   => 'Error on removing Description',
            ]
        ]);
    }
}
