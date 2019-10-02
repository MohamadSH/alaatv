<?php

namespace App\Http\Controllers\Web;

use App\Classes\LiveStreamAssistant;
use App\Conductor;
use App\Dayofweek;
use App\Live;
use App\Repositories\ConductorRepo;
use App\Repositories\LiveRepo;
use App\Repositories\WeekRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class LiveController extends Controller
{
    const XMPEG_URL = 'https://alaatv.arvanlive.com/hls/test/test.m3u8';
    const DASH_XML = 'https://alaatv.arvanlive.com/dash/test/test.mpd';

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $live = false;
        $poster = null;
        $title = null;
        $fullVideo = [];
        $xMpegURL = self::XMPEG_URL;
        $dashXml = self::DASH_XML;
        $nowTime = Carbon::now('Asia/Tehran')->toTimeString();
        $today = Carbon::today()->setTimezone('Asia/Tehran');
        $todayStringDate = $today->toDateString();
        $playLiveAjaxUrl = route('web.start.live');
        $stopLiveAjaxUrl = route('web.end.live');

        /** @var DayofWeek $dayOfWeek */
        $dayOfWeek = WeekRepo::getDayOfWeek($today->dayName)->first();
        if(!isset($dayOfWeek)) {
            $message = 'روز هفته یافت نشد';
            return view('errors.404' , compact('message'));
        }

        $schedule = LiveStreamAssistant::makeScheduleOfTheWeekCollection()->toJson();

        LiveStreamAssistant::closeFinishedPrograms($todayStringDate, $nowTime);

        /** @var Conductor $liveStream */
        $liveStream = ConductorRepo::isThereLiveStream($todayStringDate)->first();
        if(isset($liveStream)){
            Cache::tags('live')->flush();
            $live = true;
            $poster = $liveStream->poster;
            $title = $liveStream->title;
            return view('pages.liveView' , compact( 'nowTime', 'schedule' , 'live' ,'poster' , 'xMpegURL' , 'dashXml' , 'fullVideo' , 'title', 'playLiveAjaxUrl', 'stopLiveAjaxUrl' ));
        }

        /** @var Live $scheduledLive */
        $scheduledLive = LiveRepo::isThereScheduledProgram($dayOfWeek, $todayStringDate , $nowTime)->first();
        if(isset($scheduledLive)) {
            $isThereFinishedProgram = ConductorRepo::isThereFinishedScheduledProgram($todayStringDate , $scheduledLive->finish_time)->first();
            if( !isset($isThereFinishedProgram)) {
                $this->insertLiveConductor($scheduledLive->start_time , $todayStringDate , '' , $scheduledLive);
                $live = true;
                $poster = $scheduledLive->poster;
            }
        }

        return view('pages.liveView' , compact( 'nowTime', 'schedule' , 'live' ,'poster' , 'xMpegURL' , 'dashXml' , 'fullVideo' , 'title', 'playLiveAjaxUrl', 'stopLiveAjaxUrl' ));
    }

    public function startLive(Request $request ){
        $today = Carbon::today()->setTimezone('Asia/Tehran');
        $now = Carbon::now('Asia/Tehran');
        $nowTime = $now->toTimeString();
        $todayStringDate = $today->toDateString();

        $liveStream = ConductorRepo::isThereLiveStream($todayStringDate)->first();
        if(isset($liveStream)){
            return response()->json([
                'A live is already going on right now',
            ] , Response::HTTP_BAD_REQUEST);
        }

        $result = $this->insertLiveConductor($nowTime ,  $todayStringDate , $request->get('title'));
        if($result) {
            Cache::tags('live')->flush();
            return response()->json([
                'live started successfully',
            ]);
        }

        return response()->json([
            'DB error on inserting into conductor',
        ] , Response::HTTP_SERVICE_UNAVAILABLE);
    }

    public function endLive(Request $request){
        $today = Carbon::today()->setTimezone('Asia/Tehran');
        $now = Carbon::now('Asia/Tehran');
        $nowTime = $now->toTimeString();
        $todayStringDate = $today->toDateString();


        $liveStream = ConductorRepo::isThereLiveStream($todayStringDate)->first();
        if(isset($liveStream)){
            Cache::tags('live')->flush();
            $liveStream->update([
                'finish_time'            =>$nowTime,
            ]);

            return response()->json([
                'live ended successfully',
            ]);
        }

        return response()->json([
            'live not found',
        ] , Response::HTTP_NOT_FOUND);
    }

    /**
     * @param string $startTime
     * @param string $todayStringDate
     * @param string $title
     * @param Live $scheduledLive
     * @return Conductor
     */
    private function insertLiveConductor(string $startTime, string $todayStringDate , string $title=null ,Live $scheduledLive=null): Conductor
    {
        return Conductor::create([
            'title'                 => (strlen($title)>0)?$title:optional($scheduledLive)->title,
            'description'           => optional($scheduledLive)->description,
            'poster'                => optional($scheduledLive)->poster,
            'date'                  => $todayStringDate,
            'scheduled_start_time'  => optional($scheduledLive)->start_time,
            'scheduled_finish_time' => optional($scheduledLive)->finish_time,
            'start_time'            => $startTime,
        ]);
    }
}
