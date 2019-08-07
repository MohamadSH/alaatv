<?php

namespace App\Http\Controllers\Web;

use App\Event;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\InsertEventResultRequest;
use App\Http\Requests\RegisterForSanatiSharifHighSchoolRequest;
use App\Traits\RequestCommon;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use SEO;

class SharifSchoolController extends Controller
{
    public function sharifLanding(Request $request)
    {
        $sharifStudentsIds =
                    [
                        302630,
                        302644,
                        302658,
                        302748,
                        302754,
                        302742,
                        302790,
                        302800,
                        302806,
                        302810,
                        302812,
                        302814,
                        302832,
                        302840,
                        302848,
                        302850,
                        302862,
                        302870,
                        302886,
                        302896,
                    ];
        $sharifStudents = User::whereIn('id' , $sharifStudentsIds)->get();

        $amirKabirStudentsIds =[
                    302930,
                    302936,
                    302940,
                    302944,
                    302944,
                    302952,
                    302958,
                    302962,
                    302964,
                    302968,
                    302974,
                    302978,
                    302986,
                    302994,
                    302998,
                    303006,
                    302922,
            ] ;
        $amirKabirStudents = User::whereIn('id' , $amirKabirStudentsIds)->get();

        $tehranStudentsIds = [
                    303042,
                    303048,
                    303050,
                    303058,
                    303062,
                    303064,
                    303066,
                    303078,
                    303082,
                    303092,
                    303098,
                    303102,
                    303104,
                    303112,
                    303126,
                    303132,
                    303134,
                    303142,
                    303146,
                    303038,
                    303024,
                            ];
        $tehranStudents = User::whereIn('id' , $tehranStudentsIds)->get();

        $beheshtiStudentsIds = [
                    303154,
                    303158,
                    303162,
                    303170,
                    303172,
                    303178,
                    303182,
                    303184,
                    303190,
                            ];
        $beheshtiStudents = User::whereIn('id' , $beheshtiStudentsIds)->get();

        return view('pages.sharifLanding' , compact('sharifStudents' , 'amirKabirStudents' , 'tehranStudents' , 'beheshtiStudents'));
    }

    public function schoolRegisterLanding(Request $request)
    {
        abort(404);
        $eventRegistered = false;
        if (Auth::check()) {
            $user  = Auth::user();
            $event = Event::where('name', 'sabtename_sharif_97')
                ->get();
            if ($event->isEmpty()) {
                dd('ثبت نام آغاز نشده است');
            } else {
                $event           = $event->first();
                $events          = $user->eventresults->where('user_id', $user->id)
                    ->where('event_id', $event->id);
                $eventRegistered = $events->isNotEmpty();
                if ($eventRegistered) {
                    $score = $events->first()->participationCodeHash;
                }
                if (isset($user->firstName) && strlen(preg_replace('/\s+/', '', $user->firstName)) > 0) {
                    $firstName = $user->firstName;
                }
                if (isset($user->lastName) && strlen(preg_replace('/\s+/', '', $user->lastName)) > 0) {
                    $lastName = $user->lastName;
                }
                if (isset($user->mobile) && strlen(preg_replace('/\s+/', '', $user->mobile)) > 0) {
                    $mobile = $user->mobile;
                }
                if (isset($user->nationalCode) && strlen(preg_replace('/\s+/', '', $user->nationalCode)) > 0) {
                    $nationalCode = $user->nationalCode;
                }
                $major = $user->major_id;
                $grade = $user->grade_id;
            }
        }
        $url   = $request->url();
        $title = $this->setting->site->seo->homepage->metaTitle;
        SEO::setTitle($title);
        SEO::opengraph()
            ->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()
            ->setSite('آلاء');
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()
            ->addImage(route('image', [
                'category' => '11',
                'w'        => '100',
                'h'        => '100',
                'filename' => $this->setting->site->siteLogo,
            ]), [
                'height' => 100,
                'width'  => 100,
            ]);
        $pageName = 'schoolRegisterLanding';

        return view('pages.schoolRegister',
            compact('pageName', 'user', 'major', 'grade', 'firstName', 'lastName', 'mobile', 'nationalCode', 'score',
                'eventRegistered'));
    }

    /**
     * Register student for sanati sharif highschool
     *
     * @param RegisterForSanatiSharifHighSchoolRequest $request
     * @param EventresultController $eventResultController
     *
     * @return Response
     */
    public function registerForSanatiSharifHighSchool(RegisterForSanatiSharifHighSchoolRequest $request, EventresultController $eventResultController)
    {
        $event = Event::where("name", "sabtename_sharif_97")
            ->get();
        if ($event->isEmpty()) {
            session()->put("error", "رخداد یافت نشد");

            return redirect()->back();
        }
        else {
            $event = $event->first();
        }

        if (Auth::check()) {
            $user = $request->user();
        }
        else {
            $registeredUser = User::where("mobile", $request->get("mobile"))
                ->where("nationalCode", $request->get("nationalCode"))
                ->get();
        }

        if (!isset($user) && $registeredUser->isEmpty()) {
            $registerRequest = new Request();
            $registerRequest->offsetSet("firstName", $request->get("firstName"));
            $registerRequest->offsetSet("lastName", $request->get("lastName"));
            $registerRequest->offsetSet("mobile", $request->get("mobile"));
            $registerRequest->offsetSet("nationalCode", $request->get("nationalCode"));
            $registerRequest->offsetSet("major_id", $request->get("major_id"));
            $registerRequest->offsetSet("grade_id", $request->get("grade_id"));
            //            $registerRequest->offsetSet("gender_id", 1);
            $registerController = new RegisterController();
            $response           = $registerController->register($registerRequest);
            if ($response->getStatusCode() != 302) {
                session()->put("error", "خطایی در ثبت اطلاعات شما اتفاق افتاد . لطفا دوباره اقدام نمایید.");

                return redirect()->back();
            }
            $user = $request->user();
        }
        else {
            if (!isset($user)) {
                $user = $registeredUser->first();
            }
            $updateRequest = new EditUserRequest();
            if ($request->has("firstName") && (!isset($user->firstName) || strlen(preg_replace('/\s+/', '',
                        $user->firstName)) == 0)) {
                $updateRequest->offsetSet("firstName", $request->get("firstName"));
            }
            if ($request->has("lastName") && (!isset($user->lastName) || strlen(preg_replace('/\s+/', '',
                        $user->lastName)) == 0)) {
                $updateRequest->offsetSet("lastName", $request->get("lastName"));
            }
            $updateRequest->offsetSet("major_id", $request->get("major_id"));
            $updateRequest->offsetSet("grade_id", $request->get("grade_id"));
            RequestCommon::convertRequestToAjax($updateRequest);
            $response = $this->update($updateRequest, $user);
            if ($response->getStatusCode() == Response::HTTP_SERVICE_UNAVAILABLE) {
                session()->put("error", "خطایی در ثبت اطلاعات شما رخ داد. لطفا مجددا اقدام نمایید");

                return redirect()->back();
            }
        }

        $eventRegistered = $user->eventresults->where("user_id", $user->id)
            ->where("event_id", $event->id);
        if ($eventRegistered->isNotEmpty()) {
            session()->put("error", "شما قبلا ثبت نام کرده اید");

            return redirect()->back();
        }
        else {
            $evenResultRequest = new InsertEventResultRequest();
            $evenResultRequest->offsetSet("user_id", $user->id);
            $evenResultRequest->offsetSet("event_id", $event->id);
            $evenResultRequest->offsetSet("participationCodeHash", $request->get("score"));
            RequestCommon::convertRequestToAjax($evenResultRequest);
            $response = $eventResultController->store($evenResultRequest);
            if ($response->getStatusCode() == Response::HTTP_SERVICE_UNAVAILABLE) {
                session()->put("error", "خطایی در ثبت نام شما رخ داد. لطفا مجددا اقدام نمایید");

                return redirect()->back();
            }
            else {
                //                $result = json_decode($response->getContent());
                //                if(isset($result->participationCode))
                //                    $participationCode = $result->participationCode;
            }
        }

        $message = "پیش ثبت نام شما در دبیرستان دانشگاه صنعتی شریف با موفقیت انجام شد .";
        if (isset($participationCode)) {
            $message .= "کد داوطلبی شما: ".$participationCode;
        }
        session()->put("success", $message);

        return redirect()->back();
    }
}
