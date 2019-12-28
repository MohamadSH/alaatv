<?php

namespace App\Http\Controllers;

use App\Faq;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class FaqController extends Controller
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
        $faqs = Faq::query();
        $product          = $request->get('product_id');
        if (isset($product)) {
            $faqs->where('product_id', $product);
        }

        return $faqs->get();
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
        $faq = Faq::create($request->all());
        date_default_timezone_set('UTC');

        if (isset($faq)) {
            session()->flash('success', 'سوال متداول با موفقیت درج شد');
        } else {
            session()->flash('error', 'خطا در درج توصیح لحظه ای');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Faq $faq
     *
     * @return JsonResponse
     */
    public function show(Faq $faq)
    {
        return response()->json([
            $faq,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Faq $faq
     *
     * @return Factory|View
     */
    public function edit(Faq $faq)
    {
        return view('product.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request         $request
     * @param Faq $faq
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Faq $faq)
    {
        if ($faq->update($request->all())) {
            Cache::tags('faq_' . $faq->id)->flush();
            session()->flash('success', 'سوال متداول با موفقیت اصلاح شد');
        } else {
            session()->flash('error', 'خطا در اصلاح توصیح لحظه ای');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Faq $faq
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Faq $faq)
    {
        if ($faq->delete()) {
            return response()->json([
                'message' => 'توضیح لخظه ای با موفقیت حذف شد',
            ]);
        }

        return response()->json([
            'error' => [
                'message' => 'Error on removing faq',
            ],
        ]);
    }
}
