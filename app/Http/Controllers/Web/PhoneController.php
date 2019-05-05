<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditPhoneRequest;
use App\Http\Requests\InsertPhoneRequest;
use App\Phone;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class PhoneController extends Controller
{
    protected $response;
    
    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:'.config('constants.EDIT_CONTACT_ACCESS'), ['only' => 'edit']);
        
        $this->response = new Response();
    }

    public function store(InsertPhoneRequest $request)
    {
        $phone = new Phone();
        $phone->fill($request->all());
        $phone->priority = preg_replace('/\s+/', '', $phone->priority);
        if (strlen($phone->priority == 0)) {
            $phone->priority = 0;
        }
        if ($phone->save()) {
            return $this->response->setStatusCode(200);
        }
        else {
            return $this->response->setStatusCode(503);
        }
    }

    public function update(EditPhoneRequest $request, $phone)
    {
        $phone->fill($request->all());
        if ($phone->update()) {
            session()->put("success", "شماره تماس با موفقیت اصلاح شد");
            
            return true;
        }
        else {
            session()->put("error", "خطای پایگاه داده.");
            
            return false;
        }
        
        return redirect()->back();
    }

    public function destroy($id)
    {
        return $id;
        //
    }
}
