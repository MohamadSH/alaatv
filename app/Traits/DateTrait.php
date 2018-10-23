<?php

namespace App\Traits;
use Carbon\Carbon;

trait DateTrait
{
    protected function jalali_to_gregorian($j_y, $j_m, $j_d, $mod = '')
    {
        $d_4 = ($j_y + 1) % 4;
        $doy_j = ($j_m < 7) ? (($j_m - 1) * 31) + $j_d : (($j_m - 7) * 30) + $j_d + 186;
        $d_33 = (int)((($j_y - 55) % 132) * .0305);
        $a = ($d_33 != 3 and $d_4 <= $d_33) ? 287 : 286;
        $b = (($d_33 == 1 or $d_33 == 2) and ($d_33 == $d_4 or $d_4 == 1)) ? 78 : (($d_33 == 3 and $d_4 == 0) ? 80 : 79);
        if ((int)(($j_y - 19) / 63) == 20) {
            $a--;
            $b++;
        }
        if ($doy_j <= $a) {
            $gy = $j_y + 621;
            $gd = $doy_j + $b;
        } else {
            $gy = $j_y + 622;
            $gd = $doy_j - $a;
        }
        foreach (array(0, 31, ($gy % 4 == 0) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31) as $gm => $v) {
            if ($gd <= $v) break;
            $gd -= $v;
        }
        return ($mod == '') ? array($gy, $gm, $gd) : $gy . $mod . $gm . $mod . $gd;
    }
  
    protected function gregorian_to_jalali($g_y, $g_m, $g_d, $mod = '')
    {
        $d_4 = $g_y % 4;
        $g_a = array(0, 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
        $doy_g = $g_a[(int)$g_m] + $g_d;
        if ($d_4 == 0 and $g_m > 2) $doy_g++;
        $d_33 = (int)((($g_y - 16) % 132) * .0305);
        $a = ($d_33 == 3 or $d_33 < ($d_4 - 1) or $d_4 == 0) ? 286 : 287;
        $b = (($d_33 == 1 or $d_33 == 2) and ($d_33 == $d_4 or $d_4 == 1)) ? 78 : (($d_33 == 3 and $d_4 == 0) ? 80 : 79);
        if ((int)(($g_y - 10) / 63) == 30) {
            $a--;
            $b++;
        }
        if ($doy_g > $b) {
            $jy = $g_y - 621;
            $doy_j = $doy_g - $b;
        } else {
            $jy = $g_y - 622;
            $doy_j = $doy_g + $a;
        }
        if ($doy_j < 187) {
            $jm = (int)(($doy_j - 1) / 31);
            $jd = $doy_j - (31 * $jm++);
        } else {
            $jm = (int)(($doy_j - 187) / 30);
            $jd = $doy_j - 186 - ($jm * 30);
            $jm += 7;
        }
        return ($mod == '') ? array($jy, $jm, $jd) : $jy . $mod . $jm . $mod . $jd;
    }
    public  function convertDate($date , $convertType){
        if(strcmp($convertType , 'toJalali') == 0 && strlen($date)>0) {
            $explodedDate = explode(" " ,$date);
            $explodedDate= $explodedDate[0];
            $explodedDate = explode("-" , $explodedDate);
            $year = $explodedDate[0];
            $month = $explodedDate[1];
            $day = $explodedDate[2] ;
            return $this->gregorian_to_jalali($year , $month , $day , "/") ;
        }elseif(strcmp($convertType , 'toMiladi') == 0 && strlen($date)>0){
            $explodedDate = explode("/" ,$date);
            $year = $explodedDate[0];
            $month = $explodedDate[1];
            $day = $explodedDate[2] ;
            return $this->jalali_to_gregorian($year , $month , $day , "-") ;
        }
    }
  
      /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->created_at);
        return $this->convertDate($this->created_at, "toJalali");
    }
    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->updated_at);
        return $this->convertDate($this->updated_at, "toJalali");
    }
}
