<?php
namespace App\Traits;


use App\User;
use App\Websitepage;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

trait Helper
{
    protected $response;



    /**
     * Sending SMS request to Mediana SMS Panel
     *
     * @param array $params
     * @return array|string
     */
    public function medianaSendSMS(array $params)
    {
        $url = config("services.medianaSMS.normal.url");

//        $rcpt_nm = array('9121111111','9122222222');
        if(isset($params["to"]))
            $rcpt_nm =  $params["to"];
        if(isset($params["from"]))
            $from = $params["from"];
        else
            $from =config("constants.SMS_PROVIDER_DEFAULT_NUMBER") ;

        $param = [
            'uname'=>config("services.medianaSMS.normal.userName"),
            'pass'=>config("services.medianaSMS.normal.password"),
            'from'=>$from,
            'message'=>$params["message"],
            'to' => json_encode($rcpt_nm, JSON_UNESCAPED_UNICODE),
            'op'=>'send'
        ];

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($handler);
        $response =  json_decode($response);
        $res_code = $response[0];
        $res_data = $response[1];

        switch ($res_code) {
            case 0 :
                return [
                    "error"=>false ,
                    "message"=>"ارسال موفقیت آمیز بود"
                ];
                break;
            default:
                return [
                    "error"=>true ,
                    "message"=>$res_data
                ];
                break;
        }
    }

    /**
     * Sending SMS request to Mediana SMS Panel
     *
     * @param array $params
     * @return string
     */
    public function medianaSendPatternSMS(array $params)
    {
        $this->response = new Response();
        $client = new \SoapClient(
            config("services.medianaSMS.pattern.url")
        );
        $user = config("services.medianaSMS.normal.userName");
        $pass = config("services.medianaSMS.normal.password");

        if(isset($params["from"]))
            $from = $params["from"];
        else
            $from = config("constants.SMS_PROVIDER_DEFAULT_NUMBER") ;

        if(isset($params["to"]))
            $rcpt_nm =  $params["to"];
        if(isset($params["patternCode"]))
            $pattern_code = $params["patternCode"];
        if(isset($params["inputData"]))
            $input_data = $params["inputData"];

        $response = $client->sendPatternSms($from , $rcpt_nm , $user , $pass , $pattern_code  , $input_data);

        if($response)
            return $this->response->setStatusCode(200);
        else
            return $this->response->setStatusCode(503);
    }

    public function medianaGetCredit()
    {
        $url = config("services.medianaSMS.normal.url");
        $param = array
        (
            'uname'=>config("services.medianaSMS.normal.userName"),
            'pass'=>config("services.medianaSMS.normal.password"),
            'op' => 'credit',
        );
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);
        $response =  json_decode($response);
        $res_code = $response[0];
        $res_data = $response[1];
        switch ($res_code) {
            case 0 :
                return $res_data;
                break;
            default:
                return false;
                break;
        }

    }

    /**
     * Generates a random password that does not belong to anyone
     *
     * @param int $length
     * @return string
     */
    public function generateRandomPassword($length)
    {
        $generatedPassword = rand(1000,9999);
        $generatedPasswordHash = bcrypt($generatedPassword);
        return ["rawPassword"=>$generatedPassword , "hashPassword"=>$generatedPasswordHash];
    }

    public function timeFilterQuery($list, $sinceDate, $tillDate, $by = 'created_at' , $sinceTime = "00:00:00" , $tillTime = "23:59:59" , $timeZoneConvert = true){
        $sinceDate = Carbon::parse($sinceDate)->format('Y-m-d') ." ". $sinceTime;
        $tillDate = Carbon::parse($tillDate)->format('Y-m-d') ." ". $tillTime;

        if($timeZoneConvert) {
            $sinceDate = Carbon::parse($sinceDate , "Asia/Tehran");
            $sinceDate->setTimezone('UTC');
            $tillDate = Carbon::parse($tillDate , "Asia/Tehran");
            $tillDate->setTimezone('UTC');
        }
        $list = $list->whereBetween($by, [$sinceDate, $tillDate]);
        return $list;
    }

    public function generateSecurePathHash($expires , $client_IP , $secret , $url)
    {
        $str =$expires.$url.$client_IP." ".$secret;
        $str = base64_encode(md5($str,true));

        $str = str_replace("+","-",$str);
        $str = str_replace("/","_",$str);
        $str = str_replace("=","",$str);
        return $str;
    }

    public function userSeen(string $path, User $user)
    {

        $productSeenCount = 0 ;

        if(isset($websitepage->id)) {
            if (!$user->seensitepages->contains($websitepage->id))
                $user->seensitepages()->attach($websitepage->id);
            else {
                $user->seensitepages()->updateExistingPivot($websitepage->id, ["numberOfVisit" => $user->seensitepages()->where("id", $websitepage->id)->first()->pivot->numberOfVisit + 1, "updated_at" => Carbon::now()]);
            }
            $productSeenCount = $websitepage->userschecked()->count();
        }
        return $productSeenCount;
    }

    public function mergeCollections($firstCollection , $secondCollection) : Collection
    {
        $merge = $firstCollection->toBase()->merge($secondCollection);

        return $merge ;
    }
}
