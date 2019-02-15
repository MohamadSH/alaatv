<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 17:17
 */

namespace App\Traits\User;


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

    public function getInfoAttribute()
    {
        return Cache::tags([
            'user',
            'major',
            'grade',
            'gender',
            'completion',
            'wallet',
        ])->remember($this->cacheKey(), config("constants.CACHE_600"), function () {
            return [
                'major'      => $this->getMajor(),
                'grade'      => $this->getGrade(),
                'gender'     => $this->getGender(),
                'completion' => (int)$this->completion(),
                'wallet'     => $this->getWallet(),
            ];
        });
    }

    protected function getMajor()
    {
        $major = $this->major;
        if (isset($major)) {
            $majorReturn = [
                'id'          => $major->id,
                'name'        => $major->name,
                'description' => $major->description,
            ];
        } else {
            $majorReturn = null;
        }
        return $majorReturn;

    }

    protected function getGrade()
    {

        $grade = $this->grade;
        if (isset($grade)) {
            $gradeReturn = [
                'id'          => $grade->id,
                'name'        => $grade->name,
                'hint'        => $grade->displayName,
                'description' => $grade->description,
            ];
        } else {
            $gradeReturn = null;
        }
        return $gradeReturn;
    }

    protected function getGender()
    {
        $gender = $this->gender;
        if (isset($gender)) {
            $genderReturn = [
                'id'          => $gender->id,
                'name'        => $gender->name,
                'description' => $gender->description,
            ];
        } else {
            $genderReturn = null;
        }
        return $genderReturn;
    }

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
                $customColumns = $this->lockProfile;
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
                $importantColumns = $this->completeInfo;
                break;
            case "custom":
                $importantColumns = $columns;
                break;
            default:
                $importantColumns = [];
                break;
        }

        $numberOfColumns = count($importantColumns);
        $unsetColumns = 0;
        if ($numberOfColumns > 0) {
            foreach ($tableColumns as $tableColumn) {
                if (in_array($tableColumn, $importantColumns)) {
                    if (strcmp($tableColumn, "photo") == 0 && strcmp(Auth::user()->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0) {
                        $unsetColumns++;
                    }
                    if (!isset($this->$tableColumn) || strlen(preg_replace('/\s+/', '', $this->$tableColumn)) == 0) {
                        $unsetColumns++;
                    } else if (strcmp($tableColumn, "mobile_verified_at") == 0 && !is_null($this->$tableColumn)) {
                        $unsetColumns++;
                    }
                }

            }

            return (1 - ($unsetColumns / $numberOfColumns)) * 100;
        } else return 100;

    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function Birthdate_Jalali()
    {
        $explodedDateTime = explode(" ", $this->birthdate);
        $explodedDate = $explodedDateTime[0];
        //        $explodedTime = $explodedDateTime[1] ;
        return $this->convertDate($explodedDate, "toJalali");
    }

    /**
     * Locks user's profile
     */
    public function lockProfile(): void
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

}