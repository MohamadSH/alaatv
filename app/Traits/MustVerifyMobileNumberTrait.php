<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-10-22
 * Time: 17:21
 */

namespace App\Traits;


use App\Notifications\VerifyMobile;

trait MustVerifyMobileNumberTrait
{
    /**
     * Determine if the user has verified their mobile number.
     *
     * @return bool
     */
    public function hasVerifiedMobile()
    {
        return !is_null($this->mobile_verified_at);
    }

    /**
     * Mark the given user's mobile as verified.
     *
     * @return bool
     */
    public function markMobileAsVerified()
    {
        return $this->forceFill([
            'mobile_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the mobile verification notification.
     *
     * @return void
     */
    public function sendMobileVerificationNotification()
    {
        //TODO:// Generate Verification Code,
        $this->notify(new VerifyMobile());
    }

    /**
     * get user's verification code
     *
     * @return void
     */
    public function getMobileVerificationCode()
    {

    }

    /**
     * generate a verification code for given user
     *
     * @return bool
     */
    public function setMobileVerificationCode()
    {

    }
}