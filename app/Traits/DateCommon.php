<?php namespace App\Traits;

trait DateCommon
{
    public function convertToJalaliDay($day){
        switch ($day)
        {
            case "Saturday":
                return "شنبه";
                break;
            case "Sunday":
                return "یکشنبه";
                break;
            case "Monday":
                return "دوشنبه";
                break;
            case "Tuesday":
                return "سه شنبه";
                break;
            case "Wednesday":
                return "چهارشنبه";
                break;
            case "Thursday":
                return "پنجشنبه";
                break;
            case "Friday":
                return "جمعه";
                break;
            default:
                break;
        }
    }

    public function convertToJalaliMonth($month){
        switch ($month)
        {
            case "01":
                return "فروردین";
                break;
            case "02":
                return "اردیبهشت";
                break;
            case "03":
                return "خرداد";
                break;
            case "04":
                return "تیر";
                break;
            case "05":
                return "مرداد";
                break;
            case "06":
                return "شهریور";
                break;
            case "07":
                return "مهر";
                break;
            case "08":
                return "آبان";
                break;
            case "09":
                return "آذر";
                break;
            case "10":
                return "دی";
                break;
            case "11":
                return "بهمن";
                break;
            case "12":
                return "اسفند";
                break;
            default:
                break;
        }
    }

}