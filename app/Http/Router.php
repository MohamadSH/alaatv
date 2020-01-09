<?php


namespace App\Http;


class Router extends \Illuminate\Routing\Router
{
    /**
     * Register the typical authentication routes for an application.
     *
     * @param array $options
     *
     * @return void
     */
    public function auth(array $options = [])
    {
        // Authentication Routes...
        $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
        $this->post('login', 'Auth\LoginController@login');
        if ($options['api'] ?? false) {
            $this->post('logout', 'Auth\ApiLoginController@logout')->name('api.logout');

        } else {
            $this->post('logout', 'Auth\LoginController@logout')->name('logout');
        }

        // Registration Routes...
        if ($options['register'] ?? true) {
            $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
            $this->post('register', 'Auth\RegisterController@register');
        }

        // Password Reset Routes...
        if ($options['reset'] ?? true) {
            $this->resetPassword();
        }

        // Password Confirmation Routes...
        if ($options['confirm'] ??
            class_exists($this->prependGroupNamespace('Auth\ConfirmPasswordController'))) {
            $this->confirmPassword();
        }

        // Email Verification Routes...
        if ($options['verify'] ?? false) {
            $this->emailVerification();
        }
    }
}
