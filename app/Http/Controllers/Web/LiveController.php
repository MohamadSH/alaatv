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
        $xMpegURL = 'https://alaatv.arvanlive.com/hls/test/test.m3u8';
        $dashXml = 'https://alaatv.arvanlive.com/dash/test/test.mpd';
        $user = $request->user();
        if($user->hasRole('admin')) {
            $title = 'پخش برای ادمین';
            return view('pages.liveView', compact('message', 'poster' , 'xMpegURL' , 'dashXml' , 'fullVideo' , 'title' , 'message2'));
        }

        $message = '';
        $now = Carbon::now('Asia/Tehran');
        $nowTime = $now->toTimeString();
        $today = Carbon::today()->setTimezone('Asia/Tehran');
        $todayStringDate = $today->toDateString();
        /** @var DayofWeek $dayOfWeek */
        $dayOfWeek = $this->getDayOfWeek($today->dayName)->first();
        if(!isset($dayOfWeek)) {
            $message = 'روز هفته یافت نشد';
            return view('errors.404' , compact('live', 'message'));
        }

        $liveEvent = $this->isThereLive($dayOfWeek, $todayStringDate , $now)->get();
        if($liveEvent->isEmpty()) {
            $message = 'امروز پخش زنده ای وجود ندارد';
            return view('errors.404' , compact('live', 'message'));
        }

        $currentLive = $liveEvent->where('finish_time' , '>' , $nowTime)->first();
        if(!isset($currentLive)) {
            $message = 'پخش زنده امروز به اتمام رسیده است';
            return view('errors.404' , compact('live', 'message'));
        }

        $startTime = $currentLive->start_time;
        $finishTime = $currentLive->finish_time;
        $title = $currentLive->title;

        $start  = Carbon::parse($todayStringDate .' '.$startTime,'Asia/Tehran');
        $finish = Carbon::parse($todayStringDate .' '.$finishTime,'Asia/Tehran');
        if($now->isBefore($start)) {
            $message = 'پخش زنده '.$title.' ساعت '.$startTime.' به وقت تهران شروع می شود';
            $message2 = 'هم اکنون ' .$nowTime;
            $view = 'errors.404';
        }elseif($now->between($start, $finish)){
            $view = 'pages.liveView';
        }else{
            $message = 'پخش زنده امروز به اتمام رسیده است';
            $view = 'errors.404';
        }


        $poster = $currentLive->poster;
        $fullVideo = [];
        return view($view , compact('message', 'poster' , 'xMpegURL' , 'dashXml' , 'fullVideo' , 'title' , 'message2'));
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
            ->where('last_live', '>=', $todayDate);
    }
}
