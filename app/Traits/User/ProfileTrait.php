<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 17:17
 */

namespace App\Traits\User;

use Auth;
use App\User;
use App\Afterloginformcontrol;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

trait ProfileTrait
{
    use WalletTrait;
    
    private static $beProtected = [
        "roles",
    ];
    
    /**
     * @return array
     */
    public static function getBeProtected(): array
    {
        return self::$beProtected;
    }
    
    public function bloodtype()
    {
        return $this->belongsTo("\App\Bloodtype");
    }
    
    public function grade()
    {
        return $this->belongsTo("\App\Grade");
    }
    
    public function major()
    {
        return $this->belongsTo('App\Major');
    }
    
    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }
    
    public function returnLockProfileItems()
    {
        return $this->lockProfileColumns;
    }
    
    public function returnCompletionItems()
    {
        return $this->completeInfoColumns;
    }
    
    public function returnMedicalItems()
    {
        return $this->medicalInfoColumns;
    }
    
    public function getInfoAttribute()
    {
        return Cache::tags([
            'user',
            'major',
            'grade',
            'gender',
            'completion',
            'wallet',
        ])
            ->remember($this->cacheKey(), config("constants.CACHE_600"), function () {
                return [
                    'major'      => $this->getMajor(),
                    'grade'      => $this->getGrade(),
                    'gender'     => $this->getGender(),
                    'completion' => (int) $this->completion(),
                    'wallet'     => $this->getWallet(),
                ];
            });
    }
    
    /**
     * Gets an information array of user's major
     *
     * @return array|null
     */
    protected function getMajor()
    {
        /** @var User $this */
        $major = $this->major;
        if (isset($major)) {
            $majorReturn = [
                'id'          => $major->id,
                'name'        => $major->name,
                'description' => $major->description,
            ];
        }
        else {
            $majorReturn = null;
        }
        
        return $majorReturn;
    }
    
    /**
     * Gets an information array of user's grade
     *
     * @return array|null
     */
    protected function getGrade()
    {
        
        /** @var User $this */
        $grade = $this->grade;
        if (isset($grade)) {
            $gradeReturn = [
                'id'          => $grade->id,
                'name'        => $grade->name,
                'hint'        => $grade->displayName,
                'description' => $grade->description,
            ];
        }
        else {
            $gradeReturn = null;
        }
        
        return $gradeReturn;
    }
    
    /**
     * Gets an information array of user's gender
     *
     * @return array|null
     */
    protected function getGender()
    {
        /** @var User $this */
        $gender = $this->gender;
        if (isset($gender)) {
            $genderReturn = [
                'id'          => $gender->id,
                'name'        => $gender->name,
                'description' => $gender->description,
            ];
        }
        else {
            $genderReturn = null;
        }
        
        return $genderReturn;
    }
    
    /**
     * Calculates user profile completion percentage based on passed mode
     *
     * @param  string  $type
     * @param  array   $columns
     *
     * @return float|int
     */
    public function completion($type = "full", $columns = [])
    {
        $tableColumns = Schema::getColumnListing("users");
        switch ($type) {
            case "full":
                $importantColumns = [
                    "firstName",
                    "lastName",
                    "mobile",
                    "nationalCode",
                    "province",
                    "city",
                    "address",
                    "postalCode",
                    "gender_id",
                    "mobile_verified_at",
                ];
                break;
            case "fullAddress":
                $importantColumns = [
                    "firstName",
                    "lastName",
                    "mobile",
                    "nationalCode",
                    "province",
                    "city",
                    "address",
                ];
                break;
            case "lockProfile":
                $customColumns    = $this->lockProfileColumns;
                $importantColumns = array_unique(array_merge($customColumns, Afterloginformcontrol::getFormFields()
                    ->pluck('name', 'id')
                    ->toArray()));
                break;
            case "afterLoginForm" :
                $importantColumns = Afterloginformcontrol::getFormFields()
                    ->pluck('name', 'id')
                    ->toArray();
                break;
            case "completeInfo":
                $importantColumns = $this->completeInfoColumns;
                break;
            case "custom":
                $importantColumns = $columns;
                break;
            default:
                $importantColumns = [];
                break;
        }
        
        $numberOfColumns = count($importantColumns);
        $unsetColumns    = 0;
        if ($numberOfColumns > 0) {
            foreach ($tableColumns as $tableColumn) {
                if (in_array($tableColumn, $importantColumns)) {
                    if (strcmp($tableColumn, "photo") == 0 && strcmp(Auth::user()->photo,
                            config('constants.PROFILE_DEFAULT_IMAGE')) == 0) {
                        $unsetColumns++;
                    }
                    elseif (!isset($this->$tableColumn) || strlen(preg_replace('/\s+/', '',
                            $this->$tableColumn)) == 0) {
                        $unsetColumns++;
                    }
                }
            }
            
            return (1 - ($unsetColumns / $numberOfColumns)) * 100;
        }
        else {
            return 100;
        }
    }
    
    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function Birthdate_Jalali()
    {
        $explodedDateTime = explode(" ", $this->birthdate);
        $explodedDate     = $explodedDateTime[0];
        
        //        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($explodedDate, "toJalali");
    }
    
    /**
     * Locks user's profile
     */
    public function lockHisProfile(): void
    {
        $this->lockProfile = 1;
    }
    
    /**
     *  Determines whether user's profile is locked or not
     *
     * @return bool
     */
    public function isUserProfileLocked(): bool
    {
        return $this->lockProfile == 1;
    }
    
    /**
     * Fills model from data provided by user
     *
     * @param  array  $data
     */
    public function fillByPublic(array $data)
    {
        foreach ($data as $key => $datum) {
            if ((array_key_exists($key, $this->getAttributes()) && !isset($this->$key)) || in_array($key,
                    $this->fillableByPublic)) {
                $this->$key = $datum;
            }
        }
    }
    
    /**
     * Determines whether user's profile should be locked or not
     *
     * @return bool
     */
    public function checkUserProfileForLocking(): bool
    {
        return $this->completion('lockProfile') == 100;
    }

    public function getUserStatusAttribute()
    {
        $user = $this;
        $key  = "user:userstatus".$user->cacheKey();
        return \Cache::tags(["user"])
            ->remember($key, config("constants.CACHE_600"), function () use ($user) {
                return $this->userstatus()
                    ->first()
                    ->setVisible([
                        'name',
                        'displayName',
                        'description',
                    ]);
            });
    }

    public function getEmailAttribute($value)
    {
        //ToDo :
//        if (hasAuthenticatedUserPermission('constants.SHOW_USER_EMAIL'))
            return $value;


//        return null;
    }

    public function getMobileAttribute($value)
    {
        //ToDo :
//        if (hasAuthenticatedUserPermission('constants.SHOW_USER_MOBILE'))
            return $value;


//        return null;
    }

    public function getRolesAttribute($value){
        $user = $this;
        $key  = "user:roles".$user->cacheKey();
        return \Cache::tags(["user"])
            ->remember($key, config("constants.CACHE_600"), function () use ($user) {
                if (hasAuthenticatedUserPermission(config('constants.SHOW_USER_ROLE')))
                    return $this->roles()->get();

                return null;
            });
    }

    public function getTotalBonNumberAttribute($value){
        $user = $this;
        $key  = "user:totalBonNumber".$user->cacheKey();
        return \Cache::tags(["user"])
            ->remember($key, config("constants.CACHE_600"), function () use ($user) {
                if (hasAuthenticatedUserPermission(config('constants.SHOW_USER_TOTAL_BON_NUMBER')))
                    return $this->userHasBon();

                return null;
            });
    }

    public function getJalaliUpdatedAtAttribute()
    {
        $user = $this;
        $key   = "user:jalaliUpdatedAt:".$user->cacheKey();
        return Cache::tags(["user"])
            ->remember($key, config("constants.CACHE_600"), function () use ($user) {
                if(isset($user->updated_at))
                    if (hasAuthenticatedUserPermission(config('constants.SHOW_USER_ACCESS'))) {
                        /** @var User $user */
                        return $this->convertDate($user->updated_at, "toJalali");
                    }

                return null;
            });

    }

    public function getJalaliCreatedAtAttribute()
    {
        $user = $this;
        $key   = "user:jalaliCreatedAt:".$user->cacheKey();
        return Cache::tags(["user"])
            ->remember($key, config("constants.CACHE_600"), function () use ($user) {
                if(isset($user->created_at))
                    if (hasAuthenticatedUserPermission(config('constants.SHOW_USER_ACCESS'))) {
                        /** @var User $user */
                        return $this->convertDate($user->created_at, "toJalali");
                    }

                return null;
            });

    }

    public function getEditLinkAttribute()
    {
        if (hasAuthenticatedUserPermission(config('constants.EDIT_USER_ACCESS'))) {
            return action('Web\UserController@edit', $this->id);
        }

        return null;
    }

    public function getRemoveLinkAttribute()
    {
        if (hasAuthenticatedUserPermission(config('constants.REMOVE_USER_ACCESS'))) {
            return action('Web\UserController@destroy', $this->id);
        }

        return null;
    }

}
