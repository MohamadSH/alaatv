<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2019-02-15
 * Time: 16:03
 */

namespace App\Traits\User;

use Illuminate\Support\Facades\Storage;

trait mutatorTrait
{
    /** Setter mutator for major_id
     *
     * @param $value
     */
    public function setFirstNameAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["firstName"] = null;
        }
        else {
            $this->attributes["firstName"] = $value;
        }
    }

    /** Setter mutator for major_id
     *
     * @param $value
     */
    public function setLastNameAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["lastName"] = null;
        }
        else {
            $this->attributes["lastName"] = $value;
        }
    }

    /** Setter mutator for major_id
     *
     * @param $value
     */
    public function setMajorIdAttribute($value): void
    {
        if ($value == 0) {
            $this->attributes["major_id"] = null;
        }
        else {
            $this->attributes["major_id"] = $value;
        }
    }

    /** Setter mutator for bloodtype_id
     *
     * @param $value
     */
    public function setBloodtypeIdAttribute($value): void
    {
        if ($value == 0) {
            $this->attributes["bloodtype_id"] = null;
        }
        else {
            $this->attributes["bloodtype_id"] = $value;
        }
    }

    /** Setter mutator for grade_id
     *
     * @param $value
     */
    public function setGenderIdAttribute($value): void
    {
        if ($value == 0) {
            $this->attributes["gender_id"] = null;
        }
        else {
            $this->attributes["gender_id"] = $value;
        }
    }

    /** Setter mutator for grade_id
     *
     * @param $value
     */
    public function setGradeIdAttribute($value): void
    {
        if ($value == 0) {
            $this->attributes["grade_id"] = null;
        }
        else {
            $this->attributes["grade_id"] = $value;
        }
    }

    /** Setter mutator for email
     *
     * @param $value
     */
    public function setEmailAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["email"] = null;
        }
        else {
            $this->attributes["email"] = $value;
        }
    }

    /** Setter mutator for phone
     *
     * @param $value
     */
    public function setPhoneAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["phone"] = null;
        }
        else {
            $this->attributes["phone"] = $value;
        }
    }

    /** Setter mutator for city
     *
     * @param $value
     */
    public function setCityAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["city"] = null;
        }
        else {
            $this->attributes["city"] = $value;
        }
    }

    /** Setter mutator for province
     *
     * @param $value
     */
    public function setProvinceAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["province"] = null;
        }
        else {
            $this->attributes["province"] = $value;
        }
    }

    /** Setter mutator for address
     *
     * @param $value
     */
    public function setAddressAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["address"] = null;
        }
        else {
            $this->attributes["address"] = $value;
        }
    }

    /** Setter mutator for postalCode
     *
     * @param $value
     */
    public function setPostalCodeAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["postalCode"] = null;
        }
        else {
            $this->attributes["postalCode"] = $value;
        }
    }

    /** Setter mutator for school
     *
     * @param $value
     */
    public function setSchoolAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["school"] = null;
        }
        else {
            $this->attributes["school"] = $value;
        }
    }

    /** Setter mutator for allergy
     *
     * @param $value
     */
    public function setAllergyAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["allergy"] = null;
        }
        else {
            $this->attributes["allergy"] = $value;
        }
    }

    /** Setter mutator for medicalCondition
     *
     * @param $value
     */
    public function setMedicalConditionAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["medicalCondition"] = null;
        }
        else {
            $this->attributes["medicalCondition"] = $value;
        }
    }

    /** Setter mutator for discount
     *
     * @param $value
     */
    public function setDietAttribute($value): void
    {
        if ($this->strIsEmpty($value)) {
            $this->attributes["diet"] = null;
        }
        else {
            $this->attributes["diet"] = $value;
        }
    }

    /**
     *
     */
    public function getReverseFullNameAttribute()
    {
        return ucfirst($this->lastName).' '.ucfirst($this->firstName);
    }

    public function getPhotoAttribute($value)
    {
//        $diskAdapter = Storage::disk('alaaCdnSFTP')->getAdapter();
//        $imageUrl =  $diskAdapter->getUrl($value);
//        return isset($imageUrl)?$imageUrl."?w=100&h=100" :'/acm/image/255x255.png';

        $profileImage = ($value != null ? $value : config('constants.PROFILE_DEFAULT_IMAGE'));
        $profileImage = route('image', [
            'category' => '1',
            'w'        => '100',
            'h'        => '100',
            'filename' => $profileImage,
        ]);

        return $profileImage;
    }

    public function getCustomSizePhoto(int $width , int $height){
        $value = $this->getOriginal('photo');
//
//        $diskAdapter = Storage::disk('alaaCdnSFTP')->getAdapter();
//        $imageUrl =  $diskAdapter->getUrl($value);
//        return isset($imageUrl)?$imageUrl."?w=$width&h=$height" :'/acm/image/255x255.png';


        $profileImage = ($value != null ? $value : config('constants.PROFILE_DEFAULT_IMAGE'));
        $profileImage = route('image', [
            'category' => '1',
            'w'        => $width,
            'h'        => $height,
            'filename' => $profileImage,
        ]);

        return $profileImage;
    }

    public function getShortNameAttribute()
    {
        if (isset($this->firstName)) {
            return ucfirst($this->firstName);
        }
        if (isset($this->lastName)) {
            return ucfirst($this->lastName);
        }

        return 'کاربر آلایی';
    }

    public function getFullNameAttribute($value)
    {
        if(!isset($this->firstName) && !isset($this->lastName)){
            return null;
        }

        return ucfirst($this->firstName).' '.ucfirst($this->lastName);
    }
}
