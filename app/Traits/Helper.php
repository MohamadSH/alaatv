<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Collection;

trait Helper
{
    protected $response;
    
    public function medianaGetCredit()
    {
        $url     = config("services.medianaSMS.normal.url");
        $param   = [
            'uname' => config("services.medianaSMS.normal.userName"),
            'pass'  => config("services.medianaSMS.normal.password"),
            'op'    => 'credit',
        ];
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);
        $response = json_decode($response);
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
     * Sending SMS request to Mediana SMS Panel
     *
     * @param  array  $params
     *
     * @return array|string
     */
    public function medianaSendSMS(array $params)
    {
        $url = config("services.medianaSMS.normal.url");

//        $rcpt_nm = array('9121111111','9122222222');
        if (isset($params["to"])) {
            $rcpt_nm = $params["to"];
        }
        if (isset($params["from"])) {
            $from = $params["from"];
        } else {
            $from = config("constants.SMS_PROVIDER_DEFAULT_NUMBER");
        }
        
        $param = [
            'uname'   => config("services.medianaSMS.normal.userName"),
            'pass'    => config("services.medianaSMS.normal.password"),
            'from'    => $from,
            'message' => $params["message"],
            'to'      => json_encode($rcpt_nm),
            'op'      => 'send',
        ];
        
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($handler);
        $response = json_decode($response);
        $res_code = $response[0];
        $res_data = $response[1];
        
        switch ($res_code) {
            case 0 :
                return [
                    "error"   => false,
                    "message" => "ارسال موفقیت آمیز بود",
                ];
                break;
            default:
                return [
                    "error"   => true,
                    "message" => $res_data,
                ];
                break;
        }
    }


    /**
     * Generates a random password that does not belong to anyone
     *
     * @param  int  $length
     *
     * @return array
     */
    public function generateRandomPassword($length)
    {
        $generatedPassword     = rand(1000, 9999);

        return [
            "rawPassword"  => $generatedPassword,
            "hashPassword" => bcrypt($generatedPassword),
        ];
    }
    
    public function timeFilterQuery($list, $sinceDate, $tillDate, $by = 'created_at', $sinceTime = "00:00:00", $tillTime = "23:59:59", $timeZoneConvert = true)
    {
        $sinceDate = Carbon::parse($sinceDate)
                ->format('Y-m-d')." ".$sinceTime;
        $tillDate  = Carbon::parse($tillDate)
                ->format('Y-m-d')." ".$tillTime;

        if ($timeZoneConvert) {
            $sinceDate = Carbon::parse($sinceDate, "Asia/Tehran");
            $sinceDate->setTimezone('UTC');
            $tillDate = Carbon::parse($tillDate, "Asia/Tehran");
            $tillDate->setTimezone('UTC');
        }
        $list = $list->whereBetween($by, [
            $sinceDate,
            $tillDate,
        ]);

        return $list;
    }
    
    public function generateSecurePathHash($expires, $client_IP, $secret, $url)
    {
        $str = $expires.$url.$client_IP." ".$secret;
        $str = base64_encode(md5($str, true));
        
        $str = str_replace("+", "-", $str);
        $str = str_replace("/", "_", $str);
        $str = str_replace("=", "", $str);
        
        return $str;
    }
    
    public function mergeCollections($firstCollection, $secondCollection): Collection
    {
        return $firstCollection->toBase()
            ->merge($secondCollection);
    }
    
    /**
     * Update model without touching it's updated_at
     *
     * @return bool
     */
    public function updateWithoutTimestamp(): bool
    {
        $this->timestamps = false;
        $flag             = $this->update();
        $this->timestamps = true;
        
        return $flag;
    }
}
