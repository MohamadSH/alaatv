<?php

namespace App;

use App\Traits\Helper;
use Carbon\Carbon;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Schema;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Support\Facades\Config;


class User extends Authenticatable
{
//    use EntrustUserTrait {
//        EntrustUserTrait::restore insteadof SoftDeletes;
//    }

    use LaratrustUserTrait;

    use Notifiable;

    use SoftDeletes, CascadeSoftDeletes;
    use Helper;

    protected $cascadeDeletes = ['orders', 'userbons', 'useruploads', 'verificationmessages', 'bankaccounts', 'contacts', 'mbtianswers'];
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $lockProfile = ["province", "city", "address", "postalCode", "school", "gender_id", "major_id", "email"]; //columns being used for locking user's profile
    protected $completeInfo = ["photo", "province", "city", "address", "postalCode", "school", "gender_id", "major_id", "grade_id", "phone", "bloodtype_id", "allergy", "medicalCondition", "diet"];
    protected $medicalInfo = ["bloodtype_id", "allergy", "medicalCondition", "diet"];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'mobile',
        'password',
        'nationalCode',
        'mobileNumberVerification',
        'photo',
        'province',
        'city',
        'address',
        'postalCode',
        'school',
        'major_id',
        'grade_id',
        'gender_id',
        'userstatus_id',
        'email',
        'bio',
        'phone',
        'whatsapp',
        'skype',
        'bloodtype_id',
        'allergy',
        'medicalCondition',
        'diet',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cacheKey()
    {
        $key = $this->getKey();
        $time= isset($this->update) ? $this->updated_at->timestamp : $this->created_at->timestamp;
        return sprintf(
            "%s-%s",
            //$this->getTable(),
            $key,
            $time
        );
    }

    public static function roleFilter(Collection $users, $rolesId)
    {
        $key="user:roleFilter:".implode($users->pluck('id')->toArray())."-".$rolesId;

        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use($users, $rolesId) {

            $users = $users->whereHas('roles', function ($q) use ($rolesId) {
                $q->whereIn("id", $rolesId);
            });
            return $users;
        });
    }

    public static function majorFilter($users, $majorsId)
    {
        $key="user:majorFilter:".implode($users->pluck('id')->toArray())."-".$majorsId;

        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use($users, $majorsId) {

            if (in_array(0, $majorsId))
                $users = $users->whereDoesntHave("major");
            else
                $users = $users->whereIn("major_id", $majorsId);

            return $users;

        });


    }

    public static function orderStatusFilter($users, $orderStatusesId)
    {
        $key="user:orderStatusFilter:".implode($users->pluck('id')->toArray())."-".$orderStatusesId;

        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use($users, $orderStatusesId) {

            return $users->whereIn('id', Order::whereIn("orderstatus_id", $orderStatusesId)->pluck('user_id'));
        });

    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function major()
    {
        return $this->belongsTo('App\Major');
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }

    public function userstatus()
    {
        return $this->belongsTo('App\Userstatus');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function openOrders()
    {
        return $this->hasMany('App\Order')->where("orderstatus_id", Config::get("constants.ORDER_STATUS_OPEN"));
    }

    public function userbons()
    {
        return $this->hasMany('\App\Userbon');
    }

    public function useruploads()
    {
        return $this->hasMany('\App\Userupload');
    }

    public function verificationmessages()
    {
        return $this->hasMany('\App\Verificationmessage');
    }

    public function bankaccounts()
    {
        return $this->hasMany('\App\Bankaccount');
    }

    public function contacts()
    {
        return $this->hasMany('\App\Contact');
    }

    public function mbtianswers()
    {
        return $this->hasMany('\App\Mbtianswer');
    }

    public function seensitepages()
    {//Site pages that user has seen
        return $this->belongsToMany('\App\Websitepage', 'userseensitepages', 'user_id', 'websitepage_id')->withPivot("created_at", "numberOfVisit");
    }

    public function usersurveyanswers()
    {
        return $this->hasMany('\App\Usersurveyanswer');
    }

    public function eventresults()
    {
        return $this->hasMany('\App\Eventresult');
    }

    public function belongings()
    {
        return $this->belongsToMany('\App\Belonging');
    }

    public function employeeschedules()
    {
        return $this->hasMany("\App\Employeeschedule");
    }

    public function employeetimesheets()
    {
        return $this->hasMany("\App\Employeetimesheet");
    }

    public function lotteries()
    {
        return $this->belongsToMany("\App\Lottery")->withPivot("rank", "prizes");
    }

    public function bloodtype()
    {
        return $this->belongsTo("\App\Bloodtype");
    }

    public function grade()
    {
        return $this->belongsTo("\App\Grade");
    }

    public function products(){
        $result = DB::table('products')
            ->join('orderproducts', function ($join){
                $join->on('products.id', '=', 'orderproducts.product_id')
                    ->whereNull('orderproducts.deleted_at');
            })
            ->join('orders',function ($join){
                $join->on( 'orders.id', '=', 'orderproducts.order_id')
                    ->whereIn('orders.orderstatus_id',[
                        Config::get("constants.ORDER_STATUS_CLOSED"),
                        Config::get("constants.ORDER_STATUS_POSTED"),
                        Config::get("constants.ORDER_STATUS_READY_TO_POST")
                    ])
                    ->whereNull('orders.deleted_at');
            })
            ->join('users','users.id', '=', 'orders.user_id')
            ->select([

                "products.*"
            ])
            ->where('users.id','=',$this->getKey())
            ->whereNull('products.deleted_at')
            ->distinct()
            ->get();
        $result = Product::hydrate($result->toArray());

        return $result;
    }

    /**
     * @param string $bonName
     * @return number of bons that user has of the specified bon
     * Converting Created_at field to jalali
     */
    public function userHasBon($bonName)
    {
        $key="user:userHasBon:".$this->cacheKey()."-".$bonName;

        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use($bonName) {

            $bon = Bon::all()->where('name', $bonName)->where('isEnable', '=', 1);;
            if ($bon->isEmpty())
                return false;
            $userbons = $this->userbons->where("bon_id", $bon->first()->id)->where("userbonstatus_id", Config::get("constants.USERBON_STATUS_ACTIVE"));
            $totalBonNumber = 0;
            foreach ($userbons as $userbon) {
                $totalBonNumber = $totalBonNumber + $userbon->validateBon();
            }
            return $totalBonNumber;

        });

    }

    /**
     * returns user valid bons of the specified bons
     *
     * @param \app\Bon $bon
     * @param \app\User $user
     * @return  \Illuminate\Database\Eloquent\Collection a collection of user valid bons of specified bon
     */
    public function userValidBons(Bon $bon)
    {
        $key="user:userValidBons:".$this->cacheKey()."-".(isset($bon) ? $bon->cacheKey() : "");

        return Cache::remember($key,Config::get("constants.CACHE_60"),function () use($bon) {
            return Userbon::where("user_id", $this->id)->where("bon_id", $bon->id)->where("userbonstatus_id", Config::get("constants.USERBON_STATUS_ACTIVE"))->whereColumn('totalNumber', '>', 'usedNumber')
                ->where(function ($query) {
                    $query->whereNull("validSince")->orwhere("validSince", "<", Carbon::now());
                })
                ->where(function ($query) {
                    $query->whereNull("validUntil")->orwhere("validUntil", ">", Carbon::now());
                })->get();
        });

    }

    /**
     * Makes payload for Disqus SSo
     *
     * @return string
     */
    public function disqusSSO()
    {
        if (isset($this->firstName) && isset($this->lastName) && isset($this->mobile)) {
            if (isset($this->photo) && strlen($this->photo) > 0) {
                $data = array(
                    "id" => $this->mobile,
                    "username" => $this->firstName . " " . $this->lastName,
                    "email" => $this->mobile . "@takhtekhak.com",
                    "avatar" => route('image', ['category' => '1', 'w' => '39', 'h' => '39', 'filename' => $this->photo])
                );
            } else {
                $data = array(
                    "id" => $this->mobile,
                    "username" => $this->firstName . " " . $this->lastName,
                    "email" => $this->mobile . "@takhtekhak.com",
                );
            }
            $message = base64_encode(json_encode($data));
            $timestamp = time();
            $data = $message . ' ' . $timestamp;
            $key = getenv('DISQUS_PRIVATE_KEY');

            $blocksize = 64;
            $hashfunc = 'sha1';
            if (strlen($key) > $blocksize)
                $key = pack('H*', $hashfunc($key));
            $key = str_pad($key, $blocksize, chr(0x00));
            $ipad = str_repeat(chr(0x36), $blocksize);
            $opad = str_repeat(chr(0x5c), $blocksize);
            $hmac = pack(
                'H*', $hashfunc(
                    ($key ^ $opad) . pack(
                        'H*', $hashfunc(
                            ($key ^ $ipad) . $data
                        )
                    )
                )
            );
            $hmac = bin2hex($hmac);
            //            dd($message." ".$hmac." ".$timestamp);
            return $message . " " . $hmac . " " . $timestamp;
        }
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->created_at, "toJalali");
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {
        $explodedDateTime = explode(" ", $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($this->updated_at, "toJalali");
    }

    public function returnLockProfileItems()
    {
        return $this->lockProfile;
    }

    public function returnCompletionItems()
    {
        return $this->completeInfo;
    }

    public function returnMedicalItems()
    {
        return $this->medicalInfo;
    }

    public function completion($type = "full", $columns = [])
    {
        $tableColumns = Schema::getColumnListing("users");
        switch ($type) {
            case "full":
                $importantColumns = array("firstName", "lastName", "mobile", "nationalCode", "province", "city", "address", "postalCode", "gender_id", "mobileNumberVerification");
                break;
            case "fullAddress":
                $importantColumns = array("firstName", "lastName", "mobile", "nationalCode", "province", "city", "address");
                break;
            case "lockProfile":
                $customColumns = $this->lockProfile;
                $importantColumns = array_unique(array_merge($customColumns, Afterloginformcontrol::getFormFields()->pluck('name', 'id')->toArray()));
                break;
            case "afterLoginForm" :
                $importantColumns = Afterloginformcontrol::getFormFields()->pluck('name', 'id')->toArray();
                break;
            case "completeInfo":
                $importantColumns = $this->completeInfo;
                break;
            case "custom":
                $importantColumns = $columns;
                break;
            default:
                $importantColumns = array();
                break;
        }

        $numberOfColumns = count($importantColumns);
        $unsetColumns = 0;
        if ($numberOfColumns > 0) {
            foreach ($tableColumns as $tableColumn) {
                if (in_array($tableColumn, $importantColumns)) {
                    if (strcmp($tableColumn, "photo") == 0 && strcmp(Auth::user()->photo, Config::get('constants.PROFILE_DEFAULT_IMAGE')) == 0) {
                        $unsetColumns++;
                    }
                    if (!isset($this->$tableColumn) || strlen(preg_replace('/\s+/', '', $this->$tableColumn)) == 0) {
                        $unsetColumns++;
                    } elseif (strcmp($tableColumn, "mobileNumberVerification") == 0 && !$this->$tableColumn) {
                        $unsetColumns++;
                    }
                }

            }

            return (1 - ($unsetColumns / $numberOfColumns)) * 100;
        } else return 100;

    }

    public function ordermanagercomments()
    {
        return $this->hasMany('App\Ordermanagercomment');
    }

    public function getfullName($mode = "firstNameFirst")
    {
        $fullName = "";
        switch ($mode) {
            case "firstNameFirst":
                if (isset($this->firstName[0]) || isset($user->lastName[0])) {
                    if (isset($this->firstName[0])) $fullName .= $this->firstName . " ";
                    if (isset($this->lastName[0])) $fullName .= $this->lastName;

                }
                break;
            case "lastNameFirst":
                if (isset($this->firstName[0]) || isset($user->lastName[0])) {
                    if (isset($this->firstName[0])) $fullName .= $this->lastName . " ";
                    if (isset($this->lastName[0])) $fullName .= $this->firstName;
                }
                break;
            default:
                break;
        }

        return $fullName;
    }
}
