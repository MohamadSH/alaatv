<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Contacttype;
use App\Http\Requests\EditContactRequest;
use App\Http\Requests\EditPhoneRequest;
use App\Http\Requests\InsertContactRequest;
use App\Phonetype;
use App\Relative;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class ContactController extends Controller
{
    protected $response;


    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:' . Config::get('constants.LIST_CONTACT_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . Config::get('constants.REMOVE_CONTACT_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . Config::get('constants.EDIT_CONTACT_ACCESS'), ['only' => 'edit']);

        $this->response = new Response();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Input::get('user');
        if (isset($userId)) {
            $contacts = Contact::where('user_id', $userId)
                               ->orderBy("created_at", "desc")
                               ->get();
            $relatives = Relative::pluck('displayName', 'id');
            $contacttypes = Contacttype::pluck('displayName', 'id');
        } else {
            $contacts = Contact::all()
                               ->sortByDesc("created_at");
        }
        return view('contact.index', compact('contacts', 'userId', 'relatives', 'contacttypes'));
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
     * @param  \App\Http\Requests\InsertContactRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InsertContactRequest $request)
    {
        $contact = new Contact();
        $contact->fill($request->all());
        if ($contact->save()) {
            if ($request->has("isServiceRequest"))
                return $this->response->setStatusCode(200)
                                      ->setContent(["contact" => $contact]);
            else
                session()->put("success", "مخاطب با موفقیت درج شد");
        } else {
            if ($request->has("isServiceRequest"))
                return $this->response->setStatusCode(503);
            else
                session()->put("error", "خطای پایگاه داده.");
        }
        return redirect(action("ContactController@edit", $contact));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
     * @param  \App\Contact $contact
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $relatives = Relative::pluck('displayName', 'id');
        $contacttypes = Contacttype::pluck('displayName', 'id');
        $phonetypes = Phonetype::pluck('displayName', 'id');
        return view('contact.edit', compact('contact', 'relatives', 'contacttypes', 'phonetypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditContactRequest $request
     * @param  \App\Contact                          $contact
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EditContactRequest $request, $contact)
    {
        $contact->fill($request->all());
        if ($contact->update()) {
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
            if ($flag)
                session()->put("success", "اطلاعات مخاطب با موفقیت اصلاح شد");
            else
                session()->put("error", "خطای پایگاه داده.");
        } else {
            session()->put("error", "خطای پایگاه داده.");
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact $contact
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        if ($contact->delete()) {
            if (!$contact->phones->isEmpty())
                foreach ($contact->phones as $phone) {
                    $phone->delete();
                }
            session()->put("success", "مخاطب با موفقیت حذف شد");
        } else
            session()->put("error", "خطای پایگاه داده.");

        return redirect()->back();
    }
}
