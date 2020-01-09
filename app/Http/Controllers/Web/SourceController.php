<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsertSourceRequest;
use App\Http\Resources\Source as SrouceResource;
use App\Source;
use App\Traits\FileCommon;
use App\Traits\RequestCommon;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SourceController extends Controller
{
    use RequestCommon, FileCommon;

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
        $this->middleware('role:' . config('constants.ROLE_ADMIN'),);
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
     * @return Factory|View
     */
    public function index()
    {
        $sources = Source::all();
        return view('source.index', compact('sources'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InsertSourceRequest $request
     *
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function store(InsertSourceRequest $request)
    {
        $file = $this->getRequestFile($request->all(), 'photo');
        if ($file !== false) {
            $photo = $this->storePhoto($file, config('constants.DISK28'));
        }

        $source = Source::create([
            'title' => $request->get('title'),
            'link'  => $request->get('link'),
            'photo' => isset($photo) ? $photo : null,
        ]);

        if (isset($source)) {
            session()->flash('success', 'منبع با موفقیت درج شد');
        } else {
            session()->flash('error', 'خطا در درج منبع');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Source $source
     *
     * @return SrouceResource
     */
    public function show(Source $source)
    {
        return new SrouceResource($source);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Source $source
     *
     * @return Factory|View
     */
    public function edit(Source $source)
    {
        return view('source.edit', compact('source'));
    }

    /*
    |--------------------------------------------------------------------------
    | Private Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Source  $source
     *
     * @return RedirectResponse
     */
    public function update(InsertSourceRequest $request, Source $source)
    {
        $source->fill($request->all());

        $file = $this->getRequestFile($request->all(), 'photo');
        if ($file !== false) {
            $source->photo = $this->storePhoto($file, config('constants.DISK28'));
        }

        if ($source->update()) {
            session()->flash('success', 'منبع با موفقیت اصلاح شد');
        } else {
            session()->flash('error', 'خطا در اصلاح منبع');
        }

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Source $source
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Source $source)
    {
        if ($source->delete()) {
            session()->falsh('success', 'منبع با موفقیت حذف شد');
        } else {
            session()->flash('error', 'خطا در حذف منبع');
        }

        return redirect()->back();
    }
}
