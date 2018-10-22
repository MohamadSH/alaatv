<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-10-22
 * Time: 14:43
 */

namespace App\Classes\Verification;


interface MustVerifyMobileNumber
{
    /**
     * Determine if the user has verified their mobile number.
     *
     * @return bool
     */
    public function hasVerifiedMobile();

    /**
     * Mark the given user's mobile as verified.
     *
     * @return bool
     */
    public function markMobileAsVerified();

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendMobileVerificationNotification();

    /**
     * get user's verification code
     *
     * @return void
     */
    public function getMobileVerificationCode();

    /**
     * generate a verification code for given user
     *
     * @return bool
     */
    public function setMobileVerificationCode();
}