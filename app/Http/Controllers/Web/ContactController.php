<?php

namespace App\Http\Controllers\Web;

use App\Contact;
use App\Relative;
use App\Phonetype;
use App\Contacttype;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\EditPhoneRequest;
use App\Http\Requests\EditContactRequest;
use App\Http\Requests\InsertContactRequest;

class ContactController extends Controller
{
    protected $response;
    
    function __construct()
    {
        $this->middleware('permission:'.config('constants.LIST_CONTACT_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.REMOVE_CONTACT_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.EDIT_CONTACT_ACCESS'), ['only' => 'edit']);
        
        $this->response = new Response();
    }

    public function index()
    {
        $userId = Input::get('user');
        if (isset($userId)) {
            $contacts     = Contact::where('user_id', $userId)
                ->orderBy("created_at", "desc")
                ->get();
            $relatives    = Relative::pluck('displayName', 'id');
            $contacttypes = Contacttype::pluck('displayName', 'id');
        }
        else {
            $contacts = Contact::all()
                ->sortByDesc("created_at");
        }
        
        return view('contact.index', compact('contacts', 'userId', 'relatives', 'contacttypes'));
    }

    public function store(InsertContactRequest $request)
    {
        $contact = new Contact();
        $contact->fill($request->all());
        if ($contact->save()) {
            if ($request->has("isServiceRequest")) {
                return $this->response->setStatusCode(Response::HTTP_OK)
                    ->setContent(["contact" => $contact]);
            }

            session()->put("success", "مخاطب با موفقیت درج شد");
            return redirect(action("Web\ContactController@edit", $contact));
        }

        if ($request->has("isServiceRequest")) {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
        session()->put("error", "خطای پایگاه داده.");

        return redirect(action("Web\ContactController@edit", $contact));
    }

    public function edit(Contact $contact)
    {
        $relatives    = Relative::pluck('displayName', 'id');
        $contacttypes = Contacttype::pluck('displayName', 'id');
        $phonetypes   = Phonetype::pluck('displayName', 'id');
        
        return view('contact.edit', compact('contact', 'relatives', 'contacttypes', 'phonetypes'));
    }

    public function update(EditContactRequest $request, $contact)
    {
        $contact->fill($request->all());

        if (!$contact->update()) {
            session()->put("error", "خطای پایگاه داده.");
            return redirect()->back();
        }

        $flag = true;
        foreach ($contact->phones as $key => $phone) {
            $phoneUpdate = new PhoneController();
            $phoneRequest = new EditPhoneRequest();
            $phoneRequest["phoneNumber"] = $request->get("phoneNumber")[$key];
            $phoneRequest["phonetype_id"] = $request->get("phonetype_id")[$key];
            $phoneRequest["priority"] = $request->get("priority")[$key];
            if (!$phoneUpdate->update($phoneRequest, $phone)) {
                $flag = false;
                break;
            }
        }

        if ($flag) {
            session()->put("success", "اطلاعات مخاطب با موفقیت اصلاح شد");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }

        return redirect()->back();
    }

    public function destroy(Contact $contact)
    {
        if (!$contact->delete()) {
            session()->put("error", "خطای پایگاه داده.");
            return redirect()->back();
        }

        if (!$contact->phones->isEmpty()) {
            foreach ($contact->phones as $phone) {
                $phone->delete();
            }
        }

        session()->put("success", "مخاطب با موفقیت حذف شد");

        return redirect()->back();
    }
}
