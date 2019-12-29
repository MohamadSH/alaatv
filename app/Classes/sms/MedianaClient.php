<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-04-23
 * Time: 21:24
 */

namespace App\Classes\sms;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;

class MedianaClient implements SmsSenderClient
{
    /**
     * The SMS Number to send the message from.
     *
     * @var int
     */
    protected $number;

    /**
     * Username for SMS Gateway.
     *
     * @var string
     */
    protected $userName;

    /**
     * Password for SMS Gateway.
     *
     * @var string
     */
    protected $password;

    protected $url;

    /**
     * The HTTP Client instance.
     *
     * @var HttpClient
     */
    protected $http;

    public function __construct(HttpClient $http, $userName, $password, $number, $url)
    {
        $this->number   = $number;
        $this->userName = $userName;
        $this->http     = $http;
        $this->password = $password;
        $this->url      = $url;
    }

    /**
     * @param array $params
     *
     * @return array
     * @throws GuzzleException
     */
    public function send(array $params)
    {
        $url  = $this->url;
        $base = [
            'uname' => $this->userName,
            'pass'  => $this->password,
            'from'  => $this->number,
        ];
        if (isset($params['from'])) {
            unset($base["from"]);
        }

        $params = array_merge($base, $params);
        //        dd($params);

        try {
            $response = $this->http->request('POST', $url, [
                'form_params' => $params,
            ]);
        } catch (GuzzleException $e) {
            throw $e;
        }

        return json_decode((string)$response->getBody(), true);
    }
}
