<?php

namespace App\Http\Controllers\Web;

use App\Conductor;
use App\Dayofweek;
use App\Live;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

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
        $poster = '';
        $title = '';
        $fullVideo = [];
        $xMpegURL = self::XMPEG_URL;
        $dashXml = self::DASH_XML;
        $today = Carbon::today()->setTimezone('Asia/Tehran');
        $now = Carbon::now('Asia/Tehran');
        $nowTime = $this->getNowTime($now);
        $todayStringDate = $this->getTodayDateString($today);

        /** @var DayofWeek $dayOfWeek */
        $dayOfWeek = $this->getDayOfWeek($this->getTodayName($today))->first();
        if(!isset($dayOfWeek)) {
            $message = 'روز هفته یافت نشد';
            return view('errors.404' , compact('message'));
        }

        $schedule = $this->makeScheduleOfTheWeekCollection()->toJson();

        if($user->hasRole('admin')) {
            $live = true;
            $title = 'پخش برای ادمین';
            return view('pages.liveView', compact('nowTime', 'schedule' , 'live' ,'poster' , 'xMpegURL' , 'dashXml' , 'fullVideo' , 'title'));
        }

        $this->closeFinishedPrograms($todayStringDate, $nowTime);

        /** @var Conductor $liveStream */
        $liveStream = $this->isThereLiveStream($todayStringDate)->first();
        if(isset($liveStream)){
            $live = true;
            $poster = $liveStream->poster;
            return view('pages.liveView' , compact( 'nowTime', 'schedule' , 'live' ,'poster' , 'xMpegURL' , 'dashXml' , 'fullVideo' , 'title' ));
        }

        /** @var Live $scheduledLive */
        $scheduledLive = $this->isThereScheduledProgram($dayOfWeek, $todayStringDate , $nowTime)->first();
        if(isset($scheduledLive)) {
            $this->insertLiveConductor($scheduledLive, $scheduledLive->start_time , $todayStringDate);
            $live = true;
            $poster = $scheduledLive->poster;
        }

        return view('pages.liveView' , compact( 'nowTime', 'schedule' , 'live' ,'poster' , 'xMpegURL' , 'dashXml' , 'fullVideo' , 'title' ));
    }

    public function startLive(Request $request , Live $live){
        $today = Carbon::today()->setTimezone('Asia/Tehran');
        $now = Carbon::now('Asia/Tehran');
        $nowTime = $this->getNowTime($now);
        $todayStringDate = $this->getTodayDateString($today);

        $liveStream = $this->isThereLiveStream($todayStringDate)->first();
        if(isset($liveStream)){
            return response()->json([
                'A live is already going on right now',
            ] , Response::HTTP_BAD_REQUEST);
        }

        $this->insertLiveConductor( $live , $nowTime ,  $todayStringDate);

        return response()->json([
            'live started successfully',
        ]);
    }

    public function finishLive(Request $request){
        $today = Carbon::today()->setTimezone('Asia/Tehran');
        $now = Carbon::now('Asia/Tehran');
        $nowTime = $this->getNowTime($now);
        $todayStringDate = $this->getTodayDateString($today);


        $liveStream = $this->isThereLiveStream($todayStringDate)->first();
        if(isset($liveStream)){
            Conductor::update([
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
     * @param string $nowTime
     * @return Builder
     */
    private function isThereScheduledProgram(Dayofweek $dayOfWeek, string $todayDate , string $nowTime):Builder
    {
        return Live::where('dayofweek_id', $dayOfWeek->id)
                    ->where('enable', 1)
                    ->where('first_live' , '<=', $todayDate)
                    ->where('last_live'  , '>=', $todayDate)
                    ->where('start_time' , '<=' , $nowTime)
                    ->where('finish_time', '>=' , $nowTime);
    }

    /**
     * @param string $todayStringDate
     * @return Builder
     */
    private function isThereLiveStream(string $todayStringDate):Builder
    {
        return Conductor::where('date', $todayStringDate)
                        ->whereNull('finish_time');
    }

    /**
     * @param string $todayStringDate
     * @param string $nowTime
     */
    private function closeFinishedPrograms(string $todayStringDate, string $nowTime): void
    {
        $finishedPrograms = $this->getFinishedPrograms($todayStringDate, $nowTime)->get();
        foreach ($finishedPrograms as $finishedProgram) {
            $this->setFinishTime($finishedProgram);
        }
    }

    /**
     * @param string $todayStringDate
     * @param string $now
     * @return mixed
     */
    private function getFinishedPrograms(string $todayStringDate , string $now)
    {
        return Conductor::where('date', $todayStringDate)
                        ->whereNull('finish_time')
                        ->where('scheduled_finish_time' , '<' , $now);
    }

    /**
     * @param Conductor $finishedConductor
     */
    private function setFinishTime(Conductor $finishedConductor): void
    {
        $finishedConductor->update([
            'finish_time' => $finishedConductor->scheduled_finish_time,
        ]);

    }

    /**
     * @param Carbon $now
     * @return string
     */
    private function getNowTime(Carbon $now): string
    {
        return $now->toTimeString();
    }

    /**
     * @param Carbon $today
     * @return string
     */
    private function getTodayDateString(Carbon $today): string
    {
        return $today->toDateString();
    }

    /**
     * @param Carbon $today
     * @return string
     */
    private function getTodayName(Carbon $today): string
    {
        return $today->dayName;
    }

    /**
     * @return Collection
     */
    private function makeScheduleOfTheWeekCollection(): Collection
    {
        $schedules = $this->getScheduleOfTheWeek()->get();
        foreach ($schedules as $schedule) {
            $schedule->date = $this->getDateOfWeek($schedule->dayOfWeek->name);
        }

        return $schedules;
    }

    /**
     * @return Builder
     */
    private function getScheduleOfTheWeek():Builder
    {
        return Live::with('dayOfWeek')->orderBy('dayofweek_id');
    }

    /**
     * @param Live $scheduledLive
     * @param string $startTime
     * @param string $todayStringDate
     */
    private function insertLiveConductor(Live $scheduledLive, string $startTime, string $todayStringDate): void
    {
        Conductor::create([
            'title'                 => $scheduledLive->title,
            'description'           => $scheduledLive->description,
            'poster'                => $scheduledLive->poster,
            'date'                  => $todayStringDate,
            'scheduled_start_time'  => $scheduledLive->start_time,
            'scheduled_finish_time' => $scheduledLive->finish_time,
            'start_time'            => $startTime,
        ]);
    }

    /**
     * @param $dayName
     * @return string|null
     */
    private function getDateOfWeek($dayName): ?string
    {
        $startOfWeekDate = Carbon::now('Asia/Tehran')->startOfWeek(Carbon::SATURDAY);
        if ($dayName == 'saturday') {
            $date = $startOfWeekDate->toDateString();
        } elseif ($dayName == 'sunday') {
            $date = $startOfWeekDate->addDay()->toDateString();
        } elseif ($dayName == 'monday') {
            $date = $startOfWeekDate->addDays(2)->toDateString();
        } elseif ($dayName == 'tuesday') {
            $date = $startOfWeekDate->addDays(3)->toDateString();
        } elseif ($dayName == 'wednesday') {
            $date = $startOfWeekDate->addDays(4)->toDateString();
        } elseif ($dayName == 'thursday') {
            $date = $startOfWeekDate->addDays(5)->toDateString();
        } elseif ($dayName == 'friday') {
            $date = $startOfWeekDate->addDays(6)->toDateString();
        }
        return (isset($date))?$date:null;
    }
}
