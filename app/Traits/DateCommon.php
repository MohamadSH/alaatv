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

    public function convertToJalaliMonth($month , $mode = "NUMBER_TO_STRING"){
        if($mode == "NUMBER_TO_STRING")
        {
            $result = "";
            switch ($month)
            {
                case "1":
                case "01":
                    $result =  "فروردین";
                    break;
                case "2":
                case "02":
                    $result =  "اردیبهشت";
                    break;
                case "3":
                case "03":
                    $result =  "خرداد";
                    break;
                case "4":
                case "04":
                    $result =  "تیر";
                    break;
                case "5":
                case "05":
                    $result =  "مرداد";
                    break;
                case "6":
                case "06":
                    $result =  "شهریور";
                    break;
                case "7":
                case "07":
                    $result =  "مهر";
                    break;
                case "8":
                case "08":
                    $result =  "آبان";
                    break;
                case "9":
                case "09":
                    $result =  "آذر";
                    break;
                case "10":
                    $result =  "دی";
                    break;
                case "11":
                    $result =  "بهمن";
                    break;
                case "12":
                    $result =  "اسفند";
                    break;
                default:
                    break;
            }
        }
        elseif($mode == "STRING_TO_NUMBER")
        {
            $result = 0;
            switch ($month)
            {
                case "فروردین":
                    $result = 1;
                    break;
                case "اردیبهشت":
                    $result = 2;
                    break;
                case "خرداد":
                    $result = 3;
                    break;
                case "تیر":
                    $result = 4;
                    break;
                case "مرداد":
                    $result = 5;
                    break;
                case "شهریور":
                    $result = 6;
                    break;
                case "مهر":
                    $result = 7;
                    break;
                case "آبان":
                    $result = 8;
                    break;
                case "آذر":
                    $result = 9;
                    break;
                case "دی":
                    $result = 10;
                    break;
                case "بهمن":
                    $result = 11;
                    break;
                case "اسفند":
                    $result = 12;
                    break;
                default:
                    break;
            }
        }

        return $result ;
    }

    public function getJalaliMonthDays($month)
    {
        $days = 0 ;
        switch ($month)
        {
            case "فروردین":
                $days = 31;
                break;
            case "اردیبهشت":
                $days = 31;
                break;
            case "خرداد":
                $days = 31;
                break;
            case "تیر":
                $days = 31;
                break;
            case "مرداد":
                $days = 31;
                break;
            case "شهریور":
                $days = 31;
                break;
            case "مهر":
                $days = 30;
                break;
            case "آبان":
                $days = 30;
                break;
            case "آذر":
                $days = 30;
                break;
            case "دی":
                $days = 30;
                break;
            case "بهمن":
                $days = 30;
                break;
            case "اسفند":
                $days = 29;
                break;
            default:

                break;
        }
        return $days;
    }

    public function getFinancialYear($currentYear , $currentMonth , $pointedMonth)
    {
        $pointedYear = 0 ;
        if($currentMonth <= 6)
        {
            if($pointedMonth <= 6)
                $pointedYear = $currentYear;
            else
                $pointedYear = $currentYear - 1;
        }
        else
        {
            if($pointedMonth <= 6)
                $pointedYear = $currentYear - 1 ;
            else
                $pointedYear = $currentYear ;
        }

        return $pointedYear ;
    }
}