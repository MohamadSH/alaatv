<?php

namespace App\Http\Controllers\Web;

use App\Dayofweek;
use App\Live;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LiveController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $today = Carbon::today()->setTimezone('Asia/Tehran');
        $todayStringDate = $today->toDateString();
        /** @var DayofWeek $dayOfWeek */
        $dayOfWeek = $this->getDayOfWeek($today->dayName)->first();
        $live = $this->isThereLive($dayOfWeek, $todayStringDate)->first();

        if(!isset($live))
        {
            $live = 'notFound';
            $message = 'پخش زنده ای یافت نشد';
            return view('pages.liveView' , compact('live', 'message'));
        }

        $start  = Carbon::parse($todayStringDate .' '.$live->start_time,'Asia/Tehran');
        $finish = Carbon::parse($todayStringDate .' '.$live->finish_time,'Asia/Tehran');
        $now = Carbon::now('Asia/Tehran');
        if(!$user->hasRole('admin'))
        {
            if($now->isBefore($start) || $now->between($start, $finish)) {
                $live = 'on';
            }elseif($now->isAfter($finish)) {
                $live = 'finished';
            }
        }else{
            if($now->isBefore($start)) {
                $live = 'off';
                $message = 'پخش آنلاین 08:40 امروز شروع میشه';
            }elseif($now->between($start, $finish)){
                $live = 'on';
                $message = '';
            }else{
                $message = 'پخش آنلاید به اتمام رسیده است.';
                $live = 'off';
            }
        }

        $poster = $live->poster;
        return view('pages.liveView' , compact('live', 'message', 'poster'));
    }


    /**
     * @param string $today
     * @return mixed
     */
    private function getDayOfWeek(string $today):Builder
    {
        return Dayofweek::where('display_name', $today );
    }

    /**
     * @param Dayofweek $dayOfWeek
     * @param string $todayDate
     * @return Builder
     */
    private function isThereLive(Dayofweek $dayOfWeek, string $todayDate):Builder
    {
        return Live::where('dayofweek_id', $dayOfWeek->id)
            ->where('enable', 1)
            ->where('first_live', '<=', $todayDate)
            ->where('last_live', '>=', $todayDate);
    }
}
