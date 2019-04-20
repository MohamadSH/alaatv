<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachUserBonRequest;
use App\Http\Requests\InsertUserBonRequest;
use App\Product;
use App\Traits\Helper;
use App\Userbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class UserbonController extends Controller
{
    use Helper;

    protected $response;

    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:'.Config::get('constants.INSERT_USER_BON_ACCESS'), ['only' => 'store']);
        $this->middleware('permission:'.Config::get('constants.LIST_USER_BON_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.Config::get('constants.REMOVE_USER_BON_ACCESS'), ['only' => 'destroy']);

        $this->response = new Response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userbons = Userbon::OrderBy('created_at', 'Desc');

        $createdSinceDate = Input::get('createdSinceDate');
        $createdTillDate = Input::get('createdTillDate');
        $createdTimeEnable = Input::get('createdTimeEnable');
        if (strlen($createdSinceDate) > 0 && strlen($createdTillDate) > 0 && isset($createdTimeEnable)) {
            $userbons = $this->timeFilterQuery($userbons, $createdSinceDate, $createdTillDate, 'created_at');
        }

        $productsId = Input::get("products");
        if (isset($productsId)) {
            if (! in_array(0, $productsId)) {
                $products = Product::whereIn('id', $productsId)->get();
                foreach ($products as $product) {
                    if ($product->hasChildren()) {
                        $productsId = array_merge($productsId, Product::whereHas('parents', function ($q) use ($productsId) {
                            $q->whereIn("parent_id", $productsId);
                        })->pluck("id")->toArray());
                    }
                }
                $userbons = $userbons->whereHas("orderproduct", function ($q) use ($productsId) {
                    $q->whereIn("product_id", $productsId);
                });
            } else {
                $userbons = $userbons->whereHas("orderproduct");
            }
        }

        $firstName = trim(Input::get('firstName'));
        if (isset($firstName) && strlen($firstName) > 0) {
            $userbons = $userbons->whereHas('user', function ($q) use ($firstName) {
                $q->where('firstName', 'like', '%'.$firstName.'%');
            });
        }

        $lastName = trim(Input::get('lastName'));
        if (isset($lastName) && strlen($lastName) > 0) {
            $userbons = $userbons->whereHas('user', function ($q) use ($lastName) {
                $q->where('lastName', 'like', '%'.$lastName.'%');
            });
        }

        $nationalCode = trim(Input::get('nationalCode'));
        if (isset($nationalCode) && strlen($nationalCode) > 0) {
            $userbons = $userbons->whereHas('user', function ($q) use ($nationalCode) {
                $q->where('nationalCode', 'like', '%'.$nationalCode.'%');
            });
        }

        $mobile = trim(Input::get('mobile'));
        if (isset($mobile) && strlen($mobile) > 0) {
            $userbons = $userbons->whereHas('user', function ($q) use ($mobile) {
                $q->where('mobile', 'like', '%'.$mobile.'%');
            });
        }

        $userBonStatus = Input::get("userBonStatus");
        if (isset($userBonStatus) && strlen($userBonStatus) > 0) {
            $userbons = $userbons->where("userbonstatus_id", $userBonStatus);
        }

        $userbons = $userbons->get();

        return view('userBon.index', compact('userbons'));
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
     * @param \app\Http\Requests\InsertUserBonRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InsertUserBonRequest $request)
    {
        $userbon = new Userbon();
        $userbon->fill($request->all());
        if ($userbon->save()) {
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($userbon)
    {
        $userbon->delete();

        return redirect()->back();
    }
}
