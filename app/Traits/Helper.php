<?php

namespace App\Traits;


use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

trait Helper
{
    protected $response;

    public function medianaGetCredit()
    {
        $url = config("services.medianaSMS.normal.url");
        $param = array
        (
            'uname' => config("services.medianaSMS.normal.userName"),
            'pass' => config("services.medianaSMS.normal.password"),
            'op' => 'credit',
        );
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
     * Generates a random password that does not belong to anyone
     *
     * @param int $length
     * @return string
     */
    public function generateRandomPassword($length)
    {
        $generatedPassword = rand(1000, 9999);
        $generatedPasswordHash = bcrypt($generatedPassword);
        return ["rawPassword" => $generatedPassword, "hashPassword" => $generatedPasswordHash];
    }

    public function timeFilterQuery($list, $sinceDate, $tillDate, $by = 'created_at', $sinceTime = "00:00:00", $tillTime = "23:59:59", $timeZoneConvert = true)
    {
        $sinceDate = Carbon::parse($sinceDate)->format('Y-m-d') . " " . $sinceTime;
        $tillDate = Carbon::parse($tillDate)->format('Y-m-d') . " " . $tillTime;

        if ($timeZoneConvert) {
            $sinceDate = Carbon::parse($sinceDate, "Asia/Tehran");
            $sinceDate->setTimezone('UTC');
            $tillDate = Carbon::parse($tillDate, "Asia/Tehran");
            $tillDate->setTimezone('UTC');
        }
        $list = $list->whereBetween($by, [$sinceDate, $tillDate]);
        return $list;
    }

    public function generateSecurePathHash($expires, $client_IP, $secret, $url)
    {
        $str = $expires . $url . $client_IP . " " . $secret;
        $str = base64_encode(md5($str, true));

        $str = str_replace("+", "-", $str);
        $str = str_replace("/", "_", $str);
        $str = str_replace("=", "", $str);
        return $str;
    }

    public function userSeen(string $path, User $user)
    {

        $productSeenCount = 0;

        if (isset($websitepage->id)) {
            if (!$user->seensitepages->contains($websitepage->id))
                $user->seensitepages()->attach($websitepage->id);
            else {
                $user->seensitepages()->updateExistingPivot($websitepage->id, ["numberOfVisit" => $user->seensitepages()->where("id", $websitepage->id)->first()->pivot->numberOfVisit + 1, "updated_at" => Carbon::now()]);
            }
            $productSeenCount = $websitepage->userschecked()->count();
        }
        return $productSeenCount;
    }

    public function mergeCollections($firstCollection, $secondCollection): Collection
    {
        $merge = $firstCollection->toBase()->merge($secondCollection);

        return $merge;
    }
}
