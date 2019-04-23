<?php

namespace App\Classes\Payment;

class RedirectData
{
    private $redirectUrl;
    private $input;
    private $method;

    public static function instance(string $redirectUrl, array $input = [], string $method = 'GET'): self
    {
        return new static($redirectUrl, $input, $method);
    }
    /**
     *
     * @param string $redirectUrl
     * @param array $input
     * @param $method
     */
    private function __construct(string $redirectUrl, array $input, string $method)
    {
        $this->redirectUrl = $redirectUrl;
        $this->input = $input;
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }
}