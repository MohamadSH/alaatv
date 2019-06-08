<?php

namespace App\Http\Controllers\Web;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingPageController extends Controller
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
}
