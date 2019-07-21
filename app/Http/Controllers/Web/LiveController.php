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
        $message = '';
        $now = Carbon::now('Asia/Tehran');
        $today = Carbon::today()->setTimezone('Asia/Tehran');
        $todayStringDate = $today->toDateString();
        /** @var DayofWeek $dayOfWeek */
        $dayOfWeek = $this->getDayOfWeek($today->dayName)->first();
        if(!isset($dayOfWeek))
        {
            $message = 'روز هفته یافت نشد';
            $live = 'notFound';
            return view('errors.404' , compact('live', 'message'));
        }

        $liveEvent = $this->isThereLive($dayOfWeek, $todayStringDate , $now)->first();
        if(!isset($liveEvent))
        {
            $message = 'امروز پخش زنده ای وجود ندارد';
            $live = 'notFound';
            return view('errors.404' , compact('live', 'message'));
        }

        $startTime = $liveEvent->start_time;
        $finishTime = $liveEvent->finish_time;
        $title = $liveEvent->title;

        $start  = Carbon::parse($todayStringDate .' '.$startTime,'Asia/Tehran');
        $finish = Carbon::parse($todayStringDate .' '.$finishTime,'Asia/Tehran');
        if($user->hasRole('admin'))
        {
            $view = 'pages.liveView';
            $live = 'on';
//            if($now->isBefore($start) || $now->between($start, $finish)) {
//                $view = 'pages.liveView';
//                $live = 'on';
//            }elseif($now->isAfter($finish)) {
//                $live = 'finished';
//                $message = 'پخش آنلاین به اتمام رسیده است';
//                $view = 'errors.404';
//            }
        }else{
            if($now->isBefore($start)) {
                $live = 'off';
                $message = 'پخش آنلاین '.$title.' ساعت '.$startTime.' شروع می شود';
                $view = 'errors.404';
            }elseif($now->between($start, $finish)){
                $live = 'on';
                $view = 'pages.liveView';
            }else{
                $live = 'off';
                $message = 'پخش آنلاین به اتمام رسیده است';
                $view = 'errors.404';
            }
        }

        $xMpegURL = 'https://alaatv.arvanlive.com/hls/test/test.m3u8';
        $dashXml = 'https://alaatv.arvanlive.com/dash/test/test.mpd';
        $poster = $liveEvent->poster;
        $fullVideo = [];
        return view($view , compact('live', 'message', 'poster' , 'xMpegURL' , 'dashXml' , 'fullVideo' , 'title'));
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
     * @param Carbon $now
     * @return Builder
     */
    private function isThereLive(Dayofweek $dayOfWeek, string $todayDate , Carbon $now):Builder
    {
        return Live::where('dayofweek_id', $dayOfWeek->id)
            ->where('enable', 1)
            ->where('first_live', '<=', $todayDate)
            ->where('last_live', '>=', $todayDate)
            ->where('finish_time' , '>' , $now);
    }
}
