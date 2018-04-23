<?php

namespace App\Http\Controllers;

use App\Contentset;
use App\Sanatisharifmerge;
use App\Traits\CharacterCommon;
use App\Traits\MetaCommon;
use App\Traits\RequestCommon;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\try_fopen;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

class SanatisharifmergeController extends Controller
{
    use CharacterCommon;
    use RequestCommon;
    use MetaCommon;
    private $response;

    private function deplessonMultiplexer($deplessonid , $mod = 1){
        if($mod==1)
            $c=[];
        else
            $c = "";
        switch ($deplessonid)
        {
            case 1 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 3 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 4 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 5 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 6 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 8 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 9 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 10 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 11 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 12 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 13 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 17 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 20 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 21 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 22 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 23 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 25 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 26 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 27 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 28 :

                break;
            case 29 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 30 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 31 :

                break;
            case 32 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 33 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 34 :
                break;
            case 35 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 36 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 37 :
                break;
            case 38 :
                break;
            case 39 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 40 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 41 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 42 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 43 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 44 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 45 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 46 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 47 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 48 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی", "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 50 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 51 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 52 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 53 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 54 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 56 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 57 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 58 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 60 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 61 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 62 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 63 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 64 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 65 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 66 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 68 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 69 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 71 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 72 :
                break;
            case 73 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 74 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 75 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 76 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 77 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 78 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 79 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 80 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 81 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 84 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 86 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 87 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 88 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 89 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 90 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 91 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 92 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 93 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 94 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 95 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 96 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 97 :

                break;
            case 98 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 99 :if($mod==1)
                $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
            else
                $c = "";
                break;
            case 100 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 101 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 102 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 103 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 104 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 105 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 106 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 107 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 108 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 109 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 110 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 111 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 112 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 113 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 114 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 115 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 116 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 117 :
                break;
            case 118 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 119 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 120 :
                break;
            case 121 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 122 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 123 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 124 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 125 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 126 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 127 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 128 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 129 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 130 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 131 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 132 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 133 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 134 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 135 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 136 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 137 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 138 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 139 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 140 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 141 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 142 :
                break;
            case 143 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 144 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 145 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 146 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 147 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 148 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 149 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 150 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 151 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 152 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 153 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 154 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 155 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 156 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 157 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 158 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 159 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 160 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 162 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 163 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 164 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 165 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 166 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 167 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 168 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 169 :
                if($mod==1)
                    $c=[ "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 170 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 171 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 172 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 173 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 174 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 175 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 177 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 178 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 179 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 180 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 182 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 183 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 184 :
                break;
            case 185 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 186 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 187 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 188 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 189 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 190 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 191 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 192 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 193 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 194 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 195 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 196 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 197 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            default:
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
        }
        return $c ;
    }

    private function departmentMultiplexer($depid , $mod = 1)
    {
        $c = "" ;
        switch ($depid) {
            case 1 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 2 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 3 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 4 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 7 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 8 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 9 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 10 :
                if ($mod == 1)
                    $c = "کلاس کنکور";
                else
                    $c = "";
                break;
            case 11 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 12 :
                if ($mod == 1)
                    $c = "کلاس کنکور";
                else
                    $c = "";
                break;
            case 13 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 14 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 15 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 16 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 17 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 18 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 19 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 20 :
                if ($mod == 1)
                    $c = "کلاس کنکور";
                else
                    $c = "";
                break;
            case 21 :
                if ($mod == 1)
                    $c = "کلاس کنکور";
                else
                    $c = "";
                break;
            case 22 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 23 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 24 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 25 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 26 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 27 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 28 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 29 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 30 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 31 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 32 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 33 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 35 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 36 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 37 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 38 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 39 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 40 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 41 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 42 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 43 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 44 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 45 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            case 46 :
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
            default:
                if ($mod == 1)
                    $c = "";
                else
                    $c = "";
                break;
        }
        return $c;
    }

    private function determineTags($deplessonid)
    {
        $tags = $this->deplessonMultiplexer($deplessonid,1);
        if(is_array($tags))
            return $tags;
        else
            return [];
    }

    private function determineContentSetName($deplessonid , $lessonname , $depname , $depyear)
    {
        /**making year label* */
//            $year_remanider = (int)$sanatisharifRecord->depyear % 100 ;
        $year_plus_remainder = (int)$depyear % 100 +1 ;
        $yearLabel = "($depyear-$year_plus_remainder)" ;
        $name = $lessonname . " ".$depname ." ".$yearLabel ;
        $specialName = $this->deplessonMultiplexer($deplessonid,2);
        if(is_string($specialName) && isset($specialName[0])) $name = $specialName ;
        return $name;
    }

    private function determineAuthor($userFullName)
    {
        $userId = 0 ;
        switch ($userFullName)
        {
            case "رضاشامیزاده":
                $userId = 1;
                break;
            case "روحاللهحاجیسلیمانی":
                $userId = 2;
                break;
            case "محسنشهریان":
                break;
            case "علیرضارمضانی":
                break;
            case "پدرامعلیمرادی":
                break;
            case "عبدالرضامرادی":
                break;
            case "علیاکبرعزتی":
                break;
            case "مسعودحدادی":
                break;
            case "محسنکریمی":
                break;
            case "محمدرضامقصوری":
                break;
            case "امینیرادامینیراد":
                break;
            case "مهدیتفتی":
                break;
            case "جعفری":
                break;
            case "حمیدفداییفرد":
                break;
            case "کیاوشفراهانی":
                break;
            case "مصطفیجعفرینژاد":
                break;
            case "رفیعرفیعی":
                break;
            case "علیصدری":
                break;
            case "امیدزاهدی":
                break;
            case "محسنمعینی":
                break;
            case "ناصحزاده":
                break;
            case "محسنآهویی":
                break;
            case "مهدیشریعت":
                break;
            case "سیدحسامالدینجلالی":
                break;
            case "ابوالفضلجعفری":
                break;
            default:
                break ;
        }
        return $userId ;
    }
    protected function determineContentSetName($deplessonid)
    {
        $name = null;
        s($deplessonid,$name,0);
        return $name;
    }

    public function __construct()
    {
        $this->response = new Response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sanatisharifRecord = new Sanatisharifmerge();
        $sanatisharifRecord->fill($request->all());
        if($sanatisharifRecord->save())
        {
            return $this->response->setStatusCode(200);
        }
        else
        {
            return $this->response->setStatusCode(503);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sanatisharifmerge  $sanatisharifmerge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sanatisharifmerge)
    {
        $sanatisharifmerge->fill($request->all());
        if($sanatisharifmerge->update())
        {
            return $this->response->setStatusCode(200);
        }else
        {
            return $this->response->setStatusCode(503);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     *    METHODS FOR COPYING DATA IN TO TAKHTEKHAK TABLES
     */

    public function copyDepartmentlesson()
    {
        try {
            $sanatisharifRecords = Sanatisharifmerge::whereNull("videoid")->whereNull("pamphletid")->whereNotNull("departmentlessonid")->where("departmentlessonTransferred" , 0)->get();
//        $sanatisharifRecords = Sanatisharifmerge::groupBy('departmentlessonid')->where("departmentlessonTransferred" , 0);
            //Bug: farze kon ye deplesson ham khodesh vared shode ham video barayash vared shode. man chon bar asase sotoone departmentlessonTransferred filter mikonam
            // var recordi ke deplessonid va videoid darad dataye departmentlessonTransferred sefr ast kare filtere man ra kharab mikonad

            dump("number of available deplessons : ".count($sanatisharifRecords));
            $successCoutner = 0;
            $failedCounter = 0 ;
            foreach ($sanatisharifRecords as $sanatisharifRecord)
            {
                $request = new Request();

                $name = $this->determineContentSetName($sanatisharifRecord->departmentlessonid , $sanatisharifRecord->lessonname , $sanatisharifRecord->depname,$sanatisharifRecord->depyear) ;
                $request->offsetSet("id" , $sanatisharifRecord->departmentlessonid);
                $request->offsetSet("name" , $name);
                $request->offsetSet("enable" , $sanatisharifRecord->departmentlessonEnable);
                $request->offsetSet("display" , $sanatisharifRecord->departmentlessonEnable);

                $tags = $this->determineTags($sanatisharifRecord->departmentlessonid);
                array_push($tags , "کلاس_درس");
                if( strlen($this->departmentMultiplexer($sanatisharifRecord->depid) ) > 0 ) $depTag = $this->departmentMultiplexer($sanatisharifRecord->depid);
                else $depTag = $sanatisharifRecord->depname;
                array_push($tags , $this->make_slug( $depTag, "_"));
                array_push($tags , $this->make_slug($sanatisharifRecord->lessonname , "_"));
                array_push($tags , $this->make_slug($sanatisharifRecord->teacherfirstname . " ".$sanatisharifRecord->teacherlastname , "_") );
                if(!empty($tags))
                {
                    $request->offsetSet("tags" , json_encode($tags));
                }
                dump($tags);
                $controller = new ContentsetController();
                $response = $controller->store($request);
                if($response->getStatusCode() == 200)
                {
                    $request = new Request();
                    $request->offsetSet("departmentlessonTransferred" , 1);
                    $response = $this->update($request , $sanatisharifRecord);
                    if($response->getStatusCode() == 200)
                    {
                        $successCoutner++;
                    }elseif($response->getStatusCode() == 503)
                    {
                        dump("departmentlesson state wasn't saved. id: ".$sanatisharifRecord->departmentlessonid);
                        $failedCounter++;
                    }
                }
                elseif($response->getStatusCode() == 503)
                {
                    $failedCounter++;
                    dump("departmentlesson wasn't transferred. id: ".$sanatisharifRecord->departmentlessonid);
                }
            }
            dump("number of failed: ".$failedCounter);
            dump("number of successful : ".$successCoutner);
            return $this->response->setStatusCode(200)->setContent(["message"=>"Creating Playlists Done Successfully"]);

        } catch (\Exception    $e) {
            $message = "unexpected error";
            return $this->response->setStatusCode(503)->setContent(["message" => $message, "error" => $e->getMessage(), "line" => $e->getLine()]);
        }
    }
    public function copyContent()
    {
        try{
            if(!Input::has("type")) return $this->response->setStatusCode(422)->setContent(["message"=>"Wrong inputs: Please pass parameter t. Available values: p , v"]);
            else $contentType = Input::get("type");

            switch ($contentType)
            {
                case "v" :
                    $contentTypeLable = "video";
                    $contentTypePersianLable = "فیلم";
                    break;
                case "p" :
                    $contentTypeLable = "pamphlet";
                    $contentTypePersianLable = "جزوه";
                    break;
                default:
                    break;
            }
            dump( "start time (sending request to remote):". Carbon::now("asia/tehran"));
            $sanatisharifRecords = Sanatisharifmerge::whereNotNull($contentTypeLable."id")->where($contentTypeLable."Transferred" , 0)->get();
//            dd(count($sanatisharifRecords));
            $idColumn = $contentTypeLable."id";
            $nameColumn = $contentTypeLable."name";
            $descriptionColumn = $contentTypeLable."descrip";
            $enableColumn = $contentTypeLable."Enable";
            $sessionColumn = $contentTypeLable."session";
            $threshold = 500;
            $counter = 0 ;
            $successCounter = 0 ;
            $failCounter = 0;
            $warningCounter = 0;
            $skippedCounter = 0 ;
            dump( "start time (processing response data):". Carbon::now("asia/tehran"));
            dump(count($sanatisharifRecords)." records available for transfer");
            foreach ($sanatisharifRecords as $sanatisharifRecord)
            {
                if($counter >= $threshold) break;
                try{
                    $request = new Request();
                    $storeContentReuest = new \App\Http\Requests\InsertEducationalContentRequest();
                    dump($contentTypeLable."id ".$sanatisharifRecord->$idColumn." started");
                    switch ($contentType)
                    {
                        case "v" :
                            /**   conditional by passing some records   */
                            if( ( (!isset($sanatisharifRecord->videolink) || strlen($sanatisharifRecord->videolink)==0)
                                    && (!isset($sanatisharifRecord->videolinkhq) || strlen($sanatisharifRecord->videolinkhq) ==0)
                                    && (!isset($sanatisharifRecord->videolink240p) || strlen($sanatisharifRecord->videolink240p)==0) )
                                || (!$sanatisharifRecord->videoEnable && $sanatisharifRecord->videosession == 0) )
                            {
//                http://cdn4.takhtesefid.org/videos/hq".$video->videolinkonline.".mp4?name=hq-".$video->videolinkonline.".mp4
                                dump("Videoid ".$sanatisharifRecord->videoid." skipped");
                                if(!$sanatisharifRecord->videoEnable && $sanatisharifRecord->videosession == 0)
                                {
                                    $request->offsetSet("videoTransferred" , 2);
                                }elseif(isset($sanatisharifRecord->videolinktakhtesefid))
                                    $request->offsetSet("videoTransferred" , 4);
                                else
                                    $request->offsetSet("videoTransferred" , 3);
                                $response = $this->update($request , $sanatisharifRecord);
                                if($response->getStatusCode() == 200)
                                {

                                }elseif($response->getStatusCode() == 503)
                                {
                                    $skippedCounter++ ;
                                    dump("Skipped status wasn't saved for video: ".$sanatisharifRecord->videoid);
                                }
                                continue;
                            }

                            $files = array();
                            if(isset($sanatisharifRecord->videolink)) array_push($files ,["name"=>$sanatisharifRecord->videolink , "caption"=>"کیفیت عالی" , "label"=>"hd" ]);
                            if(isset($sanatisharifRecord->videolinkhq)) array_push($files ,["name"=>$sanatisharifRecord->videolinkhq , "caption"=>"کیفیت بالا" , "label"=>"hq" ]);
                            if(isset($sanatisharifRecord->videolink240p)) array_push($files ,["name"=>$sanatisharifRecord->videolink240p , "caption"=>"کیفیت متوسط" , "label"=>"240p" ]);
                            if(isset($sanatisharifRecord->thumbnail)) array_push($files ,["name"=>$sanatisharifRecord->thumbnail , "caption"=>"تامبنیل" , "label"=>"thumbnail" ]);
                            if(!empty($files)) $storeContentReuest->offsetSet("files" , $files );
                            $template_id = 1;
                            $contentTypeId = [8];
                            break;
                        case "p":
                            $files = array();
                            $domain = "http://sanatisharif.ir/";
                            if(isset($sanatisharifRecord->pamphletaddress)) array_push($files ,["name"=>$domain.$sanatisharifRecord->pamphletaddress  ]);
                            if(!empty($files)) $storeContentReuest->offsetSet("files" , $files );
                            $template_id = 2;
                            $contentTypeId = [1];
                            break;
                        default:
                            break;
                    }

                    $storeContentReuest->offsetSet("template_id" , $template_id);

                    if(strlen($sanatisharifRecord->$nameColumn) > 0)
                    {
                        $storeContentReuest->offsetSet("name" , $sanatisharifRecord->$nameColumn);
                        $metaTitle = strip_tags(htmlspecialchars(substr($sanatisharifRecord->$nameColumn ,0,55)));
                        $storeContentReuest->offsetSet("metaTitle" , $metaTitle );
                    }

                    if(strlen($sanatisharifRecord->$descriptionColumn) > 0)
                    {
                        $storeContentReuest->offsetSet("description" , $sanatisharifRecord->$descriptionColumn);
                        $metaDescription =  htmlspecialchars(strip_tags(substr($sanatisharifRecord->$descriptionColumn, 0 , 155)));
                        $storeContentReuest->offsetSet("metaDescription" , $metaDescription);
                    }

                    if(strlen($sanatisharifRecord->$nameColumn)>0 || strlen($sanatisharifRecord->$descriptionColumn)>0)
                    {
                        $text = strip_tags($sanatisharifRecord->$nameColumn) . " " . strip_tags($sanatisharifRecord->$descriptionColumn);
                        $text = preg_replace('/[^\p{L}|\p{N}]+/u', ' ', $text);
                        $text = preg_replace('/[\p{Z}]{2,}/u', " ", $text);

                        $addKeyword = 'دبیرستان,دانشگاه,صنعتی,شریف,آلاء,الا,دانشگاه شریف, دبیرستان شریف, فیلم, آموزش,رایگان,کنکور,امتحان نهایی,تدریس';
                        $manualKeyword = '';
                        $metaKeywords = $this->generateKeywordsMeta($text, $manualKeyword, $addKeyword);
                        $storeContentReuest->offsetSet("metaKeywords" , $metaKeywords);
                    }

                    $authorId = $this->determineAuthor(preg_replace('/\s+/', '', $sanatisharifRecord->teacherfirstname).preg_replace('/\s+/', '', $sanatisharifRecord->teacherlastname) );
                    if($authorId > 0 ) $storeContentReuest->offsetSet("author_id" , $authorId);

                    $tags = $this->determineTags($sanatisharifRecord->departmentlessonid);
                    array_push($tags , $this->make_slug($contentTypePersianLable,"_"));
                    if( strlen($this->departmentMultiplexer($sanatisharifRecord->depid) ) > 0 ) $depTag = $this->departmentMultiplexer($sanatisharifRecord->depid);
                    else $depTag = $sanatisharifRecord->depname;
                    array_push($tags , $this->make_slug( $depTag, "_"));
                    array_push($tags , $this->make_slug($sanatisharifRecord->lessonname , "_"));
                    array_push($tags , $this->make_slug($sanatisharifRecord->teacherfirstname . " ".$sanatisharifRecord->teacherlastname , "_") );
                    if(!empty($tags))
                    {
                        $storeContentReuest->offsetSet("tags" , json_encode($tags));
                    }
                    dump($tags);

                    if(!$sanatisharifRecord->$enableColumn) $storeContentReuest->offsetSet("enable" , 0);
//            $storeContentReuest->offsetSet("validSince" , ""); //ToDo

                    $storeContentReuest->offsetSet("contenttypes" , $contentTypeId);
                    if(Contentset::where("id",$sanatisharifRecord->departmentlessonid)->get()->isNotEmpty())
                    {
                        $storeContentReuest->offsetSet("contentsets" , [["id"=>$sanatisharifRecord->departmentlessonid , "order"=>$sanatisharifRecord->$sessionColumn , "isDefault"=>1]]);
                    }
                    else
                    {
                        $warningCounter++ ;
                        dump("Warning contentset was not exist. id: ".$sanatisharifRecord->departmentlessonid);
                    }
                    $storeContentReuest->offsetSet("fromAPI" , true);

                    $controller = new EducationalContentController();
                    $response = $controller->store($storeContentReuest);
                    $responseContent =  json_decode($response->getContent());
                    if($response->getStatusCode() == 200)
                    {
                        $request->offsetSet($contentTypeLable."Transferred" , 1);
                        if(isset($responseContent->id))
                            $request->offsetSet("educationalcontent_id" , $responseContent->id);
                        $response = $this->update($request , $sanatisharifRecord);
                        if($response->getStatusCode() == 200)
                        {
                             $successCounter++;
                        }elseif($response->getStatusCode() == 503)
                        {
                            $failCounter++;
                            dump("failed Transferred status wasn't saved for $contentTypeLable: ".$sanatisharifRecord->$idColumn);
                        }
                    }elseif($response->getStatusCode() == 503)
                    {
                        $failCounter++;
                        dump("failed $contentTypeLable wasn't transferred. id: ".$sanatisharifRecord->$idColumn);
                    }
                    $counter++ ;
                    dump($contentTypeLable."id ".$sanatisharifRecord->$idColumn." done");
                }catch(\Exception $e){
                    $failCounter++;
                    dump($e->getMessage());
                    dump("Error on processing $contentTypeLable ID: ".$sanatisharifRecord->$idColumn);
                }
            }
            dump($successCounter." records transferred successfully");
            dump($skippedCounter." records skipped");
            dump($failCounter." records failed");
            dump($warningCounter." warnings");
            return $this->response->setStatusCode(200)->setContent(["message"=>"Transfer Done Successfully"]);
        }catch (\Exception    $e) {
            $message = "unexpected error";
            return $this->response->setStatusCode(503)->setContent(["message"=>$message , "error"=>$e->getMessage() , "line"=>$e->getLine()]);
        }

    }

}
